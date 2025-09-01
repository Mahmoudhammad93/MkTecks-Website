<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Area;
use App\Models\Branch;
use App\Models\CartItem;
use App\Models\CartProduct;
use App\Models\CategoriesReports;
use App\Models\Category;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\CustomField;
use App\Models\Drink;
use App\Models\Extra;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use App\Shop\GuestCart;
use App\Shop\MobileCart as Cart;
use App\Shop\Myfatoorah\PaymentMyfatoorahApiV2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use MyFatoorah\Library\PaymentMyfatoorahApiV2 as LibraryPaymentMyfatoorahApiV2;

class OrderController extends Controller
{
    use Responseable;

    public function orders()
    {
        $user = Auth::user();
        $orders=Order::with('items.product')->where('user_id', $user->id)->get();
        return $this->apiResponse('success',$orders);
    }



    public function order($order)
    {        
        $order=Auth::user()->orders()->where('id',$order)->with('items.product')->first();
        if(!$order){
            return $this->apiResponse('failed',null,'Order Not Found');
        }
        foreach($order->items as $item){
            $item->product->image = asset('storage/'.$item->product->image);
        }
        return $this->apiResponse('success',$order);
    }
    
    
    public function reorder(Request $request,Cart $cart, PaymentMyfatoorahApiV2 $paymentService)
    {
        $order=$request->order;
        $order=Auth::user()->orders()->where('id',$order)->with('products')->first();
        if(!$order){
            return $this->apiResponse('failed',null,'Order Not Found');
        }
        foreach($order->products as $product){
            $product['extras'] = Extra::where('product_id', $product->product_id)->select([
                'extra_id as id'
            ])->get();
 
            $product['drinks'] = Drink::where('product_id', $product->product_id)->select([
                'drink_id as id'
            ])->get();
        }

        $user=User::find($order->user_id);
        $method=1;
        $address = 0;
        // if($request->pickup_type == 1){
        //     if(!$method){
        //         return $this->apiResponse('failed',null,__('Payment method is required'));
        //     }
            
        //     $address=$request->address_id;
        //     if(!$user->addresses->find($address)){
        //         return $this->apiResponse('failed',null,'Invalid Address');
        //     }
        // }else{
        //     $address = 0;
        // }

        if(!$request->has('branch_id') || $request->branch_id == ''){
            $request['branch_id'] = 0;
        }

        // return $order;


        $cart->empty();
        foreach($order->products as $product){
            if($order->products){
                if(!isset($product['options'])){
                    $product['options'] = [];
                }

                if(!isset($product['extras'])){
                    $product['extras'] = [];
                }

                if(!isset($product['drinks'])){
                    $product['drinks'] = [];
                }
                $cart->add($product['id'],(int)$product['qty'], $product['extras'], $product['drinks'], $product['options'], $order->coupon, $order->pickup_type, $order->branch_id, $order->car_type, $order->car_color);
            }
        }
        
        $note=$order->order_note;
        $order=$this->createOrder($user,$cart,$address,$order->note, $order->pickup_type, $order->branch_id, $order->car_type, $order->car_color);



        $curlData=[
            'InvoiceValue'=>($order->subtotal > 0)?$order->subtotal+$order->shipping:$order->total+$order->shipping,
            'CallBackUrl'=>route('payment.success'),
            'ErrorUrl'=>route('payment.failed'),
            'DisplayCurrencyIso'=>'KWD'
        ];

        $payment=$paymentService->getInvoiceURL($curlData,$method,$order->id);
        

        if($payment){
            OrderPayment::create([
                'order_id'=>$order->id,
                'key'=>$payment['invoiceId'],
                'url'=>$payment['invoiceURL'],
                'amount'=>$order->total
            ]);
            foreach($cart->cartItems as $item){
                // To get current date
                $curruntDate = date('m/d/Y');
                $date = Carbon::createFromFormat('m/d/Y', $curruntDate);
                $monthName = $date->format('F'); // Current month name

                
                $productCount = Product::where('id', $item->product_id)->first();
                if($productCount){
                    if($productCount->quantity > 0){
                        $productCount->quantity = $item->product->quantity - $item->qty;
                        $productCount->save();
                    }
                }
            }
            // $cart->empty();
            return $this->apiResponse('success',['payment_url'=>$payment['invoiceURL']]);
        }

        // $cart->empty();
        return $this->apiResponse('failed',null,'failed');
    }

    public function reorderAsGuest(Request $request,GuestCart $cart, PaymentMyfatoorahApiV2 $paymentService)
    {
        $order=$request->order;
        $order=Order::where('id',$order)->with('products')->first();
        if(!$order){
            return $this->apiResponse('failed',null,'Order Not Found');
        }
        foreach($order->products as $product){
            $product['extras'] = Extra::where('product_id', $product->product_id)->select([
                'extra_id as id'
            ])->get();
 
            $product['drinks'] = Drink::where('product_id', $product->product_id)->select([
                'drink_id as id'
            ])->get();
        }

        $user=User::find($order->user_id);
        $method=1;
        $address = 0;
        // if($request->pickup_type == 1){
        //     if(!$method){
        //         return $this->apiResponse('failed',null,__('Payment method is required'));
        //     }
            
        //     $address=$request->address_id;
        //     if(!$user->addresses->find($address)){
        //         return $this->apiResponse('failed',null,'Invalid Address');
        //     }
        // }else{
        //     $address = 0;
        // }

        if(!$request->has('branch_id') || $request->branch_id == ''){
            $request['branch_id'] = 0;
        }

        // return $order;


        $cart->empty();
        foreach($order->products as $product){
            if($order->products){
                if(!isset($product['options'])){
                    $product['options'] = [];
                }

                if(!isset($product['extras'])){
                    $product['extras'] = [];
                }

                if(!isset($product['drinks'])){
                    $product['drinks'] = [];
                }
                $cart->add($order->user_id, $product['id'],(int)$product['qty'], $product['extras'], $product['drinks'], $product['options'], $order->coupon, $order->pickup_type, $order->branch_id, $order->car_type, $order->car_color);
            }
        }
        
        $note=$order->order_note;
        $order=$this->createOrder($user,$cart,$address,$order->note, $order->pickup_type, $order->branch_id, $order->car_type, $order->car_color);



        $curlData=[
            'InvoiceValue'=>($order->subtotal > 0)?$order->subtotal+$order->shipping:$order->total+$order->shipping,
            'CallBackUrl'=>route('payment.success'),
            'ErrorUrl'=>route('payment.failed'),
            'DisplayCurrencyIso'=>'KWD'
        ];

        $payment=$paymentService->getInvoiceURL($curlData,$method,$order->id);
        

        if($payment){
            OrderPayment::create([
                'order_id'=>$order->id,
                'key'=>$payment['invoiceId'],
                'url'=>$payment['invoiceURL'],
                'amount'=>$order->total
            ]);
            foreach($cart->cartItems as $item){
                // To get current date
                $curruntDate = date('m/d/Y');
                $date = Carbon::createFromFormat('m/d/Y', $curruntDate);
                $monthName = $date->format('F'); // Current month name

                
                $productCount = Product::where('id', $item->product_id)->first();
                if($productCount){
                    if($productCount->quantity > 0){
                        $productCount->quantity = $item->product->quantity - $item->qty;
                        $productCount->save();
                    }
                }
            }
            // $cart->empty();
            return $this->apiResponse('success',['payment_url'=>$payment['invoiceURL']]);
        }

        // $cart->empty();
        return $this->apiResponse('failed',null,'failed');
    }



    public function checkout(Cart $cart,PaymentMyfatoorahApiV2 $paymentService){
        if(!$cart->qty){
            return $this->apiResponse('failed',null,'Cart is empty');
        }


        $paymentGateways=$paymentService->getVendorGateways(($cart->sub_total > 0 )?$cart->sub_total:$cart->total,'KWD');
        
        
        $user = Auth::user();
        $addresses=Address::where('user_id', $user->id)->with(['city', 'area'])->get();

        $coupon=null;

        
        foreach($cart->cartItems as $item){
            $item->product['image'] = Media::where('mediaable_id', $item->id)->first();
        }

        return response()->json([
            'status' => 'success',
            'data' => ['cart'=>$cart,'payment_methods'=>$paymentGateways,'addresses'=>$addresses]
        ]);
    }

    public function submitOrderAsGuest(Request $request,GuestCart $cart,PaymentMyfatoorahApiV2 $paymentService){
        $validation = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users,mobile'
        ]);

        if($validation->fails()){
            return response()->json([
                'status' => 'Fail',
                'data' => $validation->messages()
            ]);
        }

        $user = new User();
        $user->name = $request->full_name;
        $user->user_type = 'user';
        $user->email = $request->email;
        $user->mobile = $request->phone;
        $user->is_guest = 1;
        $user->save();

        $address = new Address();
        $address->user_id = $user->id;
        $address->gov_id = $request->gov_id;
        $address->region_id = $request->region_id;
        $address->title_name = $request->title_name;
        $address->street = $request->street;
        $address->block = $request->block;
        $address->building = $request->building;
        $address->avenue = $request->avenue;
        $address->flat = $request->flat;
        $address->role = $request->role;
        $address->save();

        $method=$request->payment_method;
        $user=$user;
        // if($request->pickup_type == 1){
        //     if(!$method){
        //         return $this->apiResponse('failed',null,__('Payment method is required'));
        //     }
    
            
        //     $address=$address->id;
        //     if(!$user->addresses->find($address)){
        //         return $this->apiResponse('failed',null,'Invalid Address');
        //     }
        // }else{
        //     $address = 0;
        // }
        $address = 0;

        if(!$request->has('branch_id') || $request->branch_id == ''){
            $request['branch_id'] = 0;
        }

        $cart->empty();
        foreach($request->products as $product){
            if($request->products){
                if(!isset($product['options'])){
                    $product['options'] = [];
                }

                if(!isset($product['extras'])){
                    $product['extras'] = [];
                }

                if(!isset($product['drinks'])){
                    $product['drinks'] = [];
                }
                $cart->add($user, $product['id'],(int)$product['qty'], $product['extras'], $product['drinks'], $product['options'], $request->coupon, $request->pickup_type, $request->branch_id, $request->car_type, $request->car_color);
            }
        }

        // return $cart->cartItems;
        
        $note=$request->order_note;
        $order=$this->createOrder($user,$cart,$address,$note, $request->pickup_type, $request->branch_id, $request->car_type, $request->car_color);


        $curlData=[
            'InvoiceValue'=>($order->subtotal > 0)?$order->subtotal+$order->shipping:$order->total+$order->shipping,
            'CallBackUrl'=>route('payment.success'),
            'ErrorUrl'=>route('payment.failed'),
            'DisplayCurrencyIso'=>'KWD'
        ];

        $payment=$paymentService->getInvoiceURL($curlData,$method,$order->id);
        

        if($payment){
            OrderPayment::create([
                'order_id'=>$order->id,
                'key'=>$payment['invoiceId'],
                'url'=>$payment['invoiceURL'],
                'amount'=>$order->total
            ]);
            foreach($cart->cartItems as $item){
                // To get current date
                $curruntDate = date('m/d/Y');
                $date = Carbon::createFromFormat('m/d/Y', $curruntDate);
                $monthName = $date->format('F'); // Current month name

                
                $productCount = Product::where('id', $item->product_id)->first();
                if($productCount){
                    if($productCount->quantity > 0){
                        $productCount->quantity = $item->product->quantity - $item->qty;
                        $productCount->save();
                    }
                }
            }
            // $cart->empty();
            return $this->apiResponse('success',['payment_url'=>$payment['invoiceURL'], 'guest_user' => $user]);
        }

        // $cart->empty();
        return $this->apiResponse('failed',null,'failed');


    }
    
    public function submitOrder(Request $request,Cart $cart,PaymentMyfatoorahApiV2 $paymentService){

        // return $request;
        // return $cart->cartItems;
        // if(!$cart->qty){
        //     return $this->apiResponse('failed',null,'Cart is empty');
        // }
        $user=Auth::user();
        $method=$request->payment_method;
        $address = 0;
        if($request->address_id != ''){
            $address=$request->address_id;
            if(!$user->addresses->find($address)){
                return $this->apiResponse('failed',null,'Invalid Address');
            }

            $address_details = Address::whereId($address)->where('user_id', $user->id)->first();
        }
        // if($request->pickup_type == 1){
        //     if(!$method){
        //         return $this->apiResponse('failed',null,__('Payment method is required'));
        //     }
            
        //     $address=$request->address_id;
        //     if(!$user->addresses->find($address)){
        //         return $this->apiResponse('failed',null,'Invalid Address');
        //     }
        // }else{
        //     $address = 0;
        // }

        if(!$request->has('branch_id') || $request->branch_id == ''){
            $request['branch_id'] = 0;
        }else{
            $branch = Branch::find($request['branch_id']);
        }

        // return $address_details;

        $cart->empty();
        foreach($request->products as $product){
            if($request->products){
                if(!isset($product['options'])){
                    $product['options'] = [];
                }

                if(!isset($product['extras'])){
                    $product['extras'] = [];
                }

                if(!isset($product['drinks'])){
                    $product['drinks'] = [];
                }
                $cart->add($product['id'],(int)$product['qty'], $product['extras'], $product['drinks'], $product['options'], $request->coupon, $request->pickup_type, $request->branch_id, $request->car_type, $request->car_color);
            }
        }

        
        $note=$request->order_note;
        $order=$this->createOrder($user,$cart,$address,$note, $request->pickup_type, $request->branch_id, $request->car_type, $request->car_color);

        $curlData=[
            'InvoiceValue'=>$request->totalPrice,
            'CallBackUrl'=>route('payment.success'),
            'ErrorUrl'=>route('payment.failed'),
            'DisplayCurrencyIso'=>'KWD'
        ];

        $payment=$paymentService->getInvoiceURL($curlData,$method,$order->id);
        

        if($payment){
            OrderPayment::create([
                'order_id'=>$order->id,
                'key'=>$payment['invoiceId'],
                'url'=>$payment['invoiceURL'],
                'amount'=>$order->total
            ]);
            foreach($cart->cartItems as $item){
                // To get current date
                $curruntDate = date('m/d/Y');
                $date = Carbon::createFromFormat('m/d/Y', $curruntDate);
                $monthName = $date->format('F'); // Current month name

                
                $productCount = Product::where('id', $item->product_id)->first();
                if($productCount){
                    if($productCount->quantity > 0){
                        $productCount->quantity = $item->product->quantity - $item->qty;
                        $productCount->save();
                    }
                }
            }
            // $cart->empty();
            return $this->apiResponse('success',['payment_url'=>$payment['invoiceURL']]);
        }

        // $cart->empty();
        return $this->apiResponse('failed',null,'failed');
    }



    public function success(Request $request,PaymentMyfatoorahApiV2 $paymentService){
        if($request->paymentId){
            $chk=$paymentService->getPaymentStatus($request->paymentId,'paymentId');
            $payment=OrderPayment::where('key',$chk->InvoiceId)->first();
            if($payment && $chk->InvoiceStatus=='Paid'){
                $payment->status=1;
                $payment->save();
                $order=$payment->order;
                $this->confirmOrder($order);
            }
            $user = User::find($order->user_id);
            if($order->address_id == 0){
                $address_details = Address::where('user_id',$order->user_id)->first();
            }else{
                $address_details = Address::find($order->address_id);
            }
            $address_details['area'] = Area::find($address_details->region_id);
            $branch = Branch::find($order->branch_id);
            // return $address_details;
            if($order->pickup_type == 2){
                createDeliveryOrder($order, $user, $address_details, $branch);
            }
            return redirect('https://mellow-kw.com/');
            return $this->apiResponse('success',['order_id'=>$order->id ,'order'=>$order]);
            
        }
        return view('admin.status.faild');
        return $this->apiResponse('failed',null,'failed');
    }
    
    public function failed(Request $request,PaymentMyfatoorahApiV2 $paymentService){
        if($request->paymentId){
            $chk=$paymentService->getPaymentStatus($request->paymentId,'paymentId');
            $payment=OrderPayment::where('key',$chk->InvoiceId)->first();
            $order=$payment->order;
            if($payment && $chk->InvoiceStatus=='Failed'){
                $payment->status=2;
                $payment->save();
            }
            return view('admin.status.faild');

            return $this->apiResponse('failed',['order_id'=>$order->id ,'order'=>$order]);
        }
        return view('admin.status.faild');
        return $this->apiResponse('failed',null,'failed');
    }


    private function confirmOrder(Order $order){
        $order->status=Order::COMPLETED_STATUS;
        $order->save();
        return $order;
    }

    private function createOrder($user,$cart,$address,$note, $pickup_type, $branch_id, $car_type, $car_color){
        $order=Order::create(['user_id'=>$user->id,'address_id'=>$address,'note'=>$note,'subtotal'=>$cart->sub_total,'total'=>$cart->total,
        'pickup_type' => $pickup_type, 'branch_id' => $branch_id, 'car_type' => $car_type, 'car_color' => $car_color, 'shipping' => 1.5]);
        foreach($cart->cartItems as $cartItem){
            OrderProduct::create(['order_id'=>$order->id,'product_id'=>$cartItem->product_id,'price'=>($cartItem->product != null)?$cartItem->product->price:0,'quantity'=>$cartItem->qty, 'total' => $order->total]);
        }
        return $order;
    }

    // public function applyCouponAsguest(Request $request, GuestCart $cart){
    //     $user = Auth::user();
    //     $coupon = Coupon::where('code', $request->coupon)->first();
    //     if($coupon){
    //         $cartItems = CartProduct::where('user_id', $user->id)->get();
    //         foreach($cartItems as $item){
    //             $item->coupon = $coupon->id;
    //             $item->save();
    //         }
    //         $cart->updateTotalWithCoupon($coupon->value, $coupon->discount_type);
    //     }
    //     return response()->json($coupon);
    //     // return $cart->cartInfo();
    // }

    public function getCoupon(Request $request){
        $coupon = Coupon::where('code', $request->coupon)->first();
        return response()->json($coupon);        
    }

    public function applyCoupon(Request $request, Cart $cart){
        $user = Auth::user();
        $coupon = Coupon::where('code', $request->coupon)->first();
        if($coupon){
            $cartItems = CartProduct::where('user_id', $user->id)->get();
            foreach($cartItems as $item){
                $item->coupon = $coupon->id;
                $item->save();
            }
            $cart->updateTotalWithCoupon($coupon->value, $coupon->discount_type);
        }
        return response()->json($coupon);
        // return $cart->cartInfo();
    }
}
