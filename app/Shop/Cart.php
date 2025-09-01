<?php

namespace App\Shop;

use App\Models\Area;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\CustomField;
use App\Models\ProductColor;
use App\Models\Translation;
use \stdClass;

class Cart
{
    public $items;
    public $total;
    public $shipping;
    public $qty;
    public $area;
    public $city;
    public $coupon;
    public $coupon_type;

    function __construct()
    {
        $cart=session('cart');
        if ($cart){
            $this->items = $cart->items;
            $this->area = $cart->area;
            $this->city = $cart->city;
            $this->shipping = $cart->shipping;
            $this->coupon = $cart->coupon;
            $this->coupon_type = $cart->coupon_type;
            $this->updateTotal();
            $this->updateQty();
        }else{
            $this->items=[];
            $this->total=0;
            $this->qty=0;
            $this->coupon=0;
            $this->coupon_type=0;
            $this->area=1;
            $this->city=1;
            $this->shipping=1;
        }
    }


    public function add($item,$qty=1,$category=null, $request=null, $options=null){
        $product=Product::find($item);
        $category=Category::where('slug',$category)->first();
        $id=0;
        if($category){
            $id=$category->id;
        }
        // return ['items' => $this->items, 'item' => $item];

        // $item_ids = [];
        // foreach($this->items as $obj){
        //     $item_ids[] = $obj['item'];
        // }

        // if(in_array($item, $item_ids)){
        //     foreach($this->items as $obj){
        //         if($obj['item'] == $item){
        //             $item_added = $obj;
        //         }
        //     }
        // }

        // $session = session()->get('cart');
        // if(isset($item_added) && $item_added['item'] == $item && $item_added['color_id'] == $request->color && $request->color != ''){
        //     $session->items[$item]['qty'] = intval($session->items[$item]['qty'])+1;
        // }elseif(isset($item_added) && $item_added['item'] == $item && $item_added['color_id'] != $request->color && $request->color != ''){
        //     $session->items[$item]['qty'] = intval($session->items[$item]['qty'])+1;
        //     $skus = array();
        //     if(gettype($session->items[$item]['color_id']) == 'array'){
        //         $colors = $session->items[$item]['color_id'];
        //         array_push($colors, intval($request->color));
        //         $session->items[$item]['color_id'] = '';
        //         $session->items[$item]['color_id'] = $colors;
        //         if(gettype($session->items[$item]['sku']) == 'array'){
        //             $skus = $session->items[$item]['sku'];
        //             array_push($skus, $request->sku);
        //             $session->items[$item]['sku'] = '';
        //             $session->items[$item]['sku'] = $skus;
        //         }elseif($session->items[$item]['sku'] != null){
        //             $skus[] = $session->items[$item]['sku'];
        //             array_push($skus, $request->sku);
        //             $session->items[$item]['sku'] = '';
        //             $session->items[$item]['sku'] = $skus;
        //         }else{
        //             $session->items[$item]['sku'] = $request->sku;
        //         }
        //     }elseif($session->items[$item]['color_id'] != ''){
        //         $colors[] = $session->items[$item]['color_id'];
        //         array_push($colors, intval($request->color));
        //         $session->items[$item]['color_id'] = '';
        //         $session->items[$item]['color_id'] = $colors;

        //         if($session->items[$item]['sku'] != null){
        //             $skus[] = $session->items[$item]['sku'];
        //             array_push($skus, $request->sku);
        //             $session->items[$item]['sku'] = '';
        //             $session->items[$item]['sku'] = $skus;
        //         }else{
        //             $session->items[$item]['sku'] = $request->sku;
        //         }
        //     }else{
        //         $session->items[$item]['color_id'] = intval($request->color);
        //     }
        // }else{
            
        // }

        if($product){
            $obj = new stdClass();
            $obj = collect(['item'=>$item,'qty'=>$qty,'options'=>$options,'category'=>$id, 'category_id'=>$category->id, 'custom_fields' => $request->custom_options, 'color_id'=>$request->color, 'size_id' => $request->size, 'sku'=>$request->sku]);
            $itemsCount = count($this->items);


            $ids = [];
                foreach($this->items as $key => $elem){
                    if($elem['sku'] == $request->sku){
                        $issetId = ['key'=> $key, 'item' => $elem['item']];
                    }
                }
                if(isset($issetId)){
                    $this->items[$issetId['key']]=['item'=>$item,'qty'=>$qty,'options'=>$options,'category'=>$id, 'category_id'=>$category->id, 'custom_fields' => $request->custom_options,'color_id'=>$request->color, 'size_id' => $request->size, 'sku'=>$request->sku];
                }else{
                    $this->items[$itemsCount+1]=['item'=>$item,'qty'=>$qty,'options'=>$options,'category'=>$id, 'category_id'=>$category->id, 'custom_fields' => $request->custom_options,'color_id'=>$request->color, 'size_id' => $request->size, 'sku'=>$request->sku];
                }
            $this->save();
            return $product->price*$qty;
        }
    }
    
    public function remove($item){
        if (isset($this->items[$item])) {
            unset($this->items[$item]);
            $this->save();
        }
    }


    public function hasItems(){
        return $this->qty?true:false;
    }

    public function updateArea(Area $area)
    {
        $cart = session()->get('cart');
        if(!$area){return false;}
        $this->area=$area->id;
        $this->city=$area->city->id;
        $shipping=0;
        if(!$area->shipping_price){
            $shipping=1;
            $this->shipping = 1;
            $cart->shipping = 1;
            $this->save();
            
        }
        
        if($area->shipping_price && $area->shipping_price>0){
            $shipping=$area->shipping_price;
            $cart->shipping = $area->shipping_price;
        }else{
            $shipping=$area->city->shipping_price;
            $cart->shipping = $area->city->shipping_price;
        }
        $this->shipping=$shipping;
        $this->save();
    }

    public function empty(){
        $this->items=[];
        $this->total=0;
        $this->qty=0;
        $this->save();
    }
    
    private function updateTotal(){
        $cart = session()->get('cart');
        $this->total=0;
        if(count($this->items)){
            foreach($this->items as $id=>$item){
                $prod=Product::select('price')->find($id);
                return $prod;
                $this->total+=$prod->price * $item['qty'];
            }
        }
    }

    public function updateTotalWithCoupon($value, $type){
        // return $type;
        $cart = session()->get('cart');
        $cart->coupon = $value;
        $this->coupon = $value;
        $cart->coupon_type = $type;
        $this->coupon_type = $type;
        $this->save();
    }
    
    
    public function products(){
        return Product::whereIn('id',$this->items)->get();
    }

    private function updateQty(){
        if(count($this->items)){
            $this->qty=array_sum(array_column($this->items,'qty'));
        }else{
            $this->qty=0;
        }
    }

    private function save(){
        $this->updateTotal();
        $this->updateQty();
        $cart=new \stdClass;
        $cart->items=$this->items;
        $cart->area=$this->area;
        $cart->city=$this->city;
        $cart->shipping=$this->shipping;
        $cart->coupon=$this->coupon;
        $cart->coupon_type=$this->coupon_type;
        session()->put('cart',$cart);
        session()->save();
    }

    public function cartInfo(){
        // return $this->items;
        $products=[];
        $data=[];
        $sub_items=[];
        foreach($this->items as $id=>$item){
            $qty=$item['qty'];
            $options=(isset($item['options']))?$item['options']:null;
            $product=Product::find($item['item']);
            // $images=$product->imagesArr();
            // $img=$images[0];
            $translated=$product->translate();
            $main_item_color = ProductColor::where('id', $item['color_id'])->where('product_id', $product->id)->first();
            $custom_fields_name = [];
            if(isset($item['custom_fields']) && count($item['custom_fields']) > 0){
                foreach($item['custom_fields'] as $field){
                    $customField = CustomField::where('id', $field)->first();
                    
                    $customField_ar = Translation::where('foreign_key', $field)
                    ->where('table_name','custom_fields')
                    ->where('column_name','name')
                    ->first();
                    if(isset($customField_ar)){
                        if(app()->getLocale() == 'ar'){
                            $custom_fields_name[] = $customField_ar->value;
                        }else{
                            $custom_fields_name[] = $customField->name;
                        }
                    }else{
                        $custom_fields_name[] = $customField->name;
                    }
                }
            }

            $category = Category::find($item['category_id']);

            $products[]=['id'=>$product->id,'slug'=>$product->slug,'name'=>$product->name,'image'=>$product->image,'qty'=>$qty,'options'=>$options,'category'=>$item['category'],'price'=>$product->price,'total'=>($product->price * $qty), 'category_id'=>$item['category_id'], 'category_slug' => $category->slug,'color_id'=>(isset($item['color_id']))?$item['color_id']:null, 'size_id'=>(isset($item['size_id']))?$item['size_id']:null, 'custom_fields'=> (isset($item['custom_fields']))?$item['custom_fields']:null,'custom_fields_name'=> $custom_fields_name, 'sku'=>($item['sku'])?$item['sku']:null, 'color'=>$main_item_color];

            if(isset($item['sub_items'])){
                $sub_item_color = Color::where('id', $item['sub_items']['color_id'])->where('product_id', $product->id)->first();
                $sub_items[]=['id'=>$product->id,'slug'=>$product->slug,'name'=>$product->name,'image'=>$product->image,'qty'=>$qty,'options'=>$options,'category'=>$item['sub_items']['category'],'price'=>$product->price,'total'=>($product->price * $qty), 'category_id'=>$item['sub_items']['category_id'], 'color_id'=>(isset($item['sub_items']['color_id']))?$item['sub_items']['color_id']:null, 'size_id'=>(isset($item['sub_items']['size_id']))?$item['sub_items']['size_id']:null, 'custom_fields'=> (isset($item['sub_items']['custom_fields']))?$item['sub_items']['custom_fields']:null, 'sku'=>($item['sub_items']['sku'])?$item['sub_items']['sku']:null, 'color'=>($sub_item_color)?$sub_item_color:null];
            }
            
        }
        $data['sub_total']=number_format(array_sum(array_column($products,'total')), 3);
        $data['shipping']=number_format($this->shipping, 3);
        $data['coupon']= ($this->coupon != null)?$this->coupon:0;
        $data['coupon_type']= ($this->coupon_type != null)?$this->coupon_type:0;
        if($data['coupon'] > 0){
            if($data['coupon_type'] == 1){
                $discount = (($data['sub_total']+$data['shipping'])*$data['coupon'])/100;
                $data['total'] = number_format(($data['sub_total']+$data['shipping']) - $discount, 3);
            }else{
                $discount = $data['coupon'];
                $data['total'] = number_format(($data['sub_total']-$data['coupon'])+$data['shipping'], 3);
            }
        }else{
            $data['total'] = number_format($data['sub_total']+$data['shipping'], 3);
        }
        $data['discount']=(isset($discount))?number_format($discount, 3):0;
        $data['qty']=$this->qty;
        $data['items']=$products;
        $data['sub_items']=$sub_items;
        return $data;
    }
}
