<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Company;
use App\Models\Media;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    use Responseable;
    
    public function index()
    {
        return $this->apiResponse('success',$this->getWithlist());
    }
    
    public function add(Request $request)
    {
        $user = Auth::user();
        $product=Product::find($request->id);

        
        if(!$product){
            return $this->apiResponse('failed', null, 'Product not found');
        }

        $wishlist=Wishlist::whereUserId($user->id)->get();
        $chk=$wishlist->where('product_id',$product->id);
        if(isset($chk) && count($chk)){
            return response()->json(['status'=>'success','count'=>$wishlist->count()]);
        }
        $row = Wishlist::create(['user_id'=>Auth::id(),'product_id'=>$product->id,'category_id'=>$product->category_id]);

        $product = Product::where('id', $row->product_id)->first();
        $row->product = $product;
        $row->product->image = asset('storage/'.$product->image);
        return $this->apiResponse('success', $row,'Product Added Successfully');
    }

    

    public function remove(Request $request)
    {
        $user=Auth::user();
        $chk=Wishlist::where('user_id', $user->id)->where('product_id',$request->id)->first();
        if(!$chk){
            return $this->apiResponse('failed', null, 'Product not found');
        }
        $chk->delete();
        return $this->apiResponse('success', null, 'Product Deleted Successfully');
    }



    private function getWithlist(){
        $user = Auth::user();
        $wishlist = Wishlist::with('product')->where('user_id', $user->id)->get();

        foreach($wishlist as $item){
            $item->product['image'] = Media::where('mediaable_id', $item->product_id)->first();
        }

        return $wishlist;
    }
}
