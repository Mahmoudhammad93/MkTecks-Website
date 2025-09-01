<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Drink;
use App\Models\Extra;
use App\Models\Media;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('components', 'image', 'images', 'options')->orderBy('id', 'desc')->get();

        foreach($products as $product){
            $product['extras'] = Extra::where('product_id', $product->id)->get();
            foreach($product->extras as $extra){
                $extra->extra = Product::whereId($extra->extra_id)->first();
            }
            
            $product['drinks'] = Drink::where('product_id', $product->id)->get();
            foreach($product->drinks as $drink){
                $drink->drink = Product::whereId($drink->drink_id)->first();
            }

            foreach($product->options as $option){
                $option->option = Option::with('properties')->whereId($option->option_id)->first();
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {        
        $product = Product::with('components:id,name,product_id', 'options', 'image', 'images')->find($id);

        if(!$product){
            return response()->json([
                'status' => 'fail',
                'message' => 'Product not found'
            ]);    
        }

        // $product->extras = Extra::where('product_id', $product->id)->get();
        // $product->drinks = Drink::where('product_id', $product->id)->get();
        foreach($product->options as $option){
            $option->option = Option::with('propertiesApi')->whereId($option->option_id)->first();
        }
        
        // return $product;
        
        // if($product->extras){
        //     foreach($product->extras as $extra){
        //         if($request->header('Accept-Language')){
        //             $extra->extra = Product::whereId($extra->extra_id)->first();
        //             // $extra->extra['image'] = Media::where('mediaable_id', $extra->extra_id)->first();
        //         }else{
        //             $extra->extra = Product::whereId($extra->extra_id)->first();
        //             // $extra->extra['image'] = Media::where('mediaable_id', $extra->extra_id)->first();
        //         }
        //     }
        // }

        // if($product->drinks){
        //     foreach($product->drinks as $drink){
        //             $drink_product = Product::whereId($drink->drink_id)->first();
        //             $drink->drink = $drink_product;
        //             // $drink_image = Media::where('mediaable_id', $drink->drink_id)->first();
        //             // if($drink_image){
        //             //     $drink->drink['image'] = $drink_image;
        //             // }
        //     }
        // }

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show the details for search the specified resource.
     */
    public function search(Request $request)
    {
        $search = Product::with('image')->where('name_ar', 'LIKE', '%' . $request->value . '%')
        ->orWhere('name_en', 'LIKE', '%' . $request->value . '%')->get();

        return response()->json([
            'status' => 'success',
            'data' => $search
        ]);
    }
}
