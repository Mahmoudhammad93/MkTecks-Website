<?php

namespace App\Http\Controllers\Api;

use App\Models\Color;
use App\Models\Extra;
use App\Models\Media;
use App\Models\Product;
use App\Models\Size;
use App\Shop\MobileCart as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends \App\Http\Controllers\Controller
{
    use Responseable;
    
    public function index(Cart $cart)
    {
        foreach($cart->cartItems as $item){
            if($item->product != null){
                $item->product->image = Media::where('mediaable_id',$item->product->id)->first();
            }
        }
        return response()->json([
            'status' => 'success',
            'data' => $cart
        ]);
    }
    
    public function add(Request $request,Cart $cart)
    {
        // return $request;
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
                $cart->add($product['id'],(int)$product['qty'], $product['options']);
            }
        }


        return $this->apiResponse('success',$cart);
    }

    public function update(Request $request,Cart $cart)
    {
        if($request->cart_item){
            $cart->updateItem($request->cart_item,(int)$request->qty,$request->options);
        }
        return $this->apiResponse('success',$cart);
    }

    public function remove(Request $request,Cart $cart)
    {
        if($request->cart_item){
            $cart->remove($request->cart_item);
        }
        return $this->apiResponse('success',$cart);
    }
    
    public function clear(Cart $cart)
    {
        
        $cart->empty();
        return $this->apiResponse('success',$cart);
    }
}
