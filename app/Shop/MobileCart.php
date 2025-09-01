<?php

namespace App\Shop;

use App\Models\CartItem;
use App\Models\CartProduct;
use App\Models\Color;
use App\Models\Component;
use App\Models\Coupon;
use App\Models\Drink;
use App\Models\Extra;
use App\Models\Option;
use App\Models\Product;
use App\Models\Properity;
use App\Models\Size;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class MobileCart
{
    public $cartItems;
    public $total_shipping;
    public $total;
    public $discount;
    public $sub_total;
    public $qty;
    public $coupon_type;
    public $coupon_value;
    public $max_discount;

    function __construct()
    {
        $this->update();
    }

    public function add($item_id,$qty=1, $extras=[], $drinks=[], $options=[], $coupon=null, $pickup_type, $branch_id, $car_type=null, $car_color=null)
    {
        $product = new CartProduct();
        $product->user_id = Auth::id();
        $product->product_id = $item_id;
        $product->qty = $qty;
        $product->color_id = 1;
        $product->size_id = 1;
        $product->sku = 1;
        // $product->extras =  json_encode($extras);
        // $product->drinks =  json_encode($drinks);
        $product->options =  json_encode($options);
        $product->coupon =  $coupon;
        $product->pickup_type =  $pickup_type;
        $product->branch_id =  $branch_id;
        $product->car_type =  $car_type;
        $product->car_color =  $car_color;
        $product->save();
        $this->update();
    }

    public function mergeSku($productSku=null,$colorSku=null, $sizeSku=null){
        return $productSku.$colorSku.$sizeSku;
    }

    public function updateItem($cartItem,$qty){
        $item=Auth::user()->cartItems->find($cartItem);
        if($item){
            $item->qty=$qty;
            $item->save();
            $this->update();
        }
    }
    
    public function remove($cartItem){
        $item=Auth::user()->cartItems->find($cartItem);
        if($item){
            $item->delete();
        }
        $this->update();
    }


    public function hasItems(){
        return $this->qty?true:false;
    }
    
    
    public function vendorItems(){
        $vendorProducts=[];
        $data=[];
        foreach($this->cartItems as $id=>$qty){
            $product=Product::find($id);
            $vendorProducts[$product->user->id]['items'][$id]=['id'=>$product->id,'name'=>$product->name,'image'=>$product->image,'qty'=>$qty,'price'=>$product->price,'total'=>($product->price * $qty)];
            if(!isset($vendorProducts[$product->user->id]['sub_total'])){
                $vendorProducts[$product->user->id]['sub_total']=0;
            }
            if(!isset($vendorProducts[$product->user->id]['shipping'])){
                $vendorProducts[$product->user->id]['shipping']=$product->user->seller_shipping;
            }
            if(!isset($vendorProducts[$product->user->id]['name'])){
                $vendorProducts[$product->user->id]['name']=$product->user->name.' '.$product->user->last_name;
            }
            $vendorProducts[$product->user->id]['sub_total']+=($product->price * $qty);
            
            $vendorProducts['total']=$vendorProducts['sub_total']+$vendorProducts['shipping'];
        }



        $data['sub_total']=array_sum(array_column($vendorProducts,'sub_total'));
        $data['total_shipping']=array_sum(array_column($vendorProducts,'shipping'));
        $data['total']=array_sum(array_column($vendorProducts,'total'));
        $data['qty']=$this->qty;
        $data['cart']=$vendorProducts;
        
        return $data;
    }

    public function empty(){
        CartProduct::where('user_id',Auth::id())->delete();
    }
    
    private function updateTotal(){
        $this->total=0;
        if(count($this->cartItems)){
            foreach($this->cartItems as $item){
                $prod=$item->product;
                if($prod){
                    $this->total+=($prod->price * $item->qty) + ($item->extras_price + $item->drinks_price+$item->options_price);
                }
            }
        }
    }

    public function updateTotalWithCoupon($value, $type){
        $this->coupon_type = $type;
        $this->coupon_value = $value;

        if($type == 1){
            $discount = ($this->total*$value)/100;
            $this->total = $this->total - $discount;
        }else{
            $this->total = $this->total - $value;
        }
    }

    private function updateQty(){
        $this->qty=0;
        if(count($this->cartItems)){
            $this->qty=$this->cartItems->sum('qty');
        }
    }

    private function update(){
        Auth::user()->load('cartItems');
        $items=Auth::user()->cartItems;
        if ($items){
            foreach($items as $item){
                // $item->extras = json_decode($item->extras);
                // $item->extras_price = 0;
                // $item->drinks_price = 0;
                $item->options_price = 0;
                // foreach($item->extras as $extra){
                //     $extra->product_extra = Extra::find($extra->id);
                //     $ex_p = Product::find($extra->id);
                //     if($ex_p){
                //         $item->extras_price += $ex_p->price;
                //     }
                    
                //     // $extra->extra = Product::find($product_extra->extra_id);
                // }

    
                // $item->drinks = json_decode($item->drinks);
                // foreach($item->drinks as $drink){
                //     $drink->product_drink = Drink::find($drink->id);
                //     $dr_p = Product::find($drink->id);
                //     if($dr_p){
                //         $item->drinks_price += $dr_p->price;
                //     }
                //     // $drink->drink = Product::find($product_drink->drink_id);
                // }
    
                $item->options = json_decode($item->options);
                foreach($item->options as $option){
                    $option->option = Properity::find($option->id);
                    // $option->option = Option::find($option->option_id);
                    if(isset($option->option)){
                        $item->options_price += $option->option->price;
                    }
                }
            }
            if(count($items) > 0){
                $coupon = Coupon::whereId($items[0]->coupon)->first();
            }
            $this->cartItems = $items;
            $this->updateTotal();
            $this->updateQty();
            $this->coupon_value = (isset($coupon) && $coupon->value != null)?$coupon->value:0;
            $this->coupon_type = (isset($coupon) && $coupon->discount_type != null)?$coupon->discount_type:0;
            $this->sub_total=0;
            if($this->coupon_value > 0){
                if($coupon->discount_type == 1){
                    $discount = $this->total*$coupon->value/100;
                }else{
                    $discount = $this->total-$coupon->value;
                }
                $this->sub_total = $this->total-$discount;
            }else{
                $this->sub_total = 0;
            }
            $this->discount=(isset($discount))?$discount:0;
        }else{
            $this->cartItems=new Collection();
            $this->total_shipping=0;
            $this->total=0;
            $this->discount=0;
            $this->qty=0;
            $this->coupon_type=null;
            $this->coupon_value=0;
            $this->max_discount=0;
        }
    }
}
