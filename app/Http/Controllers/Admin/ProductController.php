<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Component;
use App\Models\Drink;
use App\Models\Extra;
use App\Models\Media;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('image', 'category', 'components', 'options')->latest()->paginate(30);

        foreach($products as $product){
            foreach($product->options as $option){
                $option->option = Option::whereId($option->option_id)->first();
            }
        }

        // return $products;

        return view('admin.products.index', [
            'title' => trans('admin.All Products'),
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'title' => trans('admin.Add New Product'),
            'products' => Product::get(),
            'categories' => Category::orderBy('name_' . lang(), 'asc')->get(),
            'options' => Option::get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'           => 'required',
            'name_en'           => 'required',
            'category_id'       => 'required',
            'description_ar'    => 'required',
            'description_en'    => 'required',
            'price'         => 'required',
            "images"            => "required|array|min:1",
            "images.*"          => "required|image|mimes:jpeg,png,jpg,webp",
        ], [], [
            'name_ar'           => trans('admin.Name Ar'),
            'name_en'           => trans('admin.Name En'),
            'category_id'       => trans('admin.Category'),
            'description_ar'    => trans('admin.Description Ar'),
            'description_en'    => trans('admin.Description En'),
            'price'         => trans('admin.Price'),
            'images'            => trans('admin.Images'),
        ]);

        $product = Product::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'category_id' => $request->category_id,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'min_extras' => ($request->extra_min_required)?$request->extra_min_required:0,
            'min_drinks' => ($request->drink_min_required)?$request->drink_min_required:0,
            'min_options' => ($request->option_min_required)?$request->option_min_required:0
        ]);

        if ($request->hasFile('images')) {
            ini_set('memory_limit', '-1');
            $files = $request->file('images');
            $image_path = date("Y-m-d") . '/';
            foreach ($files as $file) {
                $image_extension = $file->getClientOriginalExtension();
                $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
                File::makeDirectory(public_path('storage/products/' . $image_path), $mode = 0777, true, true);
                Image::make($file)
                    ->resize(650, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('storage/products/' . $image_path) . $image_imageName, 90);
                $image = new Media();
                $image->filename = $image_imageName;
                $image->mime = $file->getClientMimeType();
                $image->mediaable_id = $product->id;
                $image->mediaable_type = 'App\Models\Product';
                $image->url = url('') . '/storage/products/' . $image_path . $image_imageName;
                $image->save();
            }
        }


        // foreach($request->components as $component){
        //     Component::create([
        //         'name' => $component,
        //         'product_id' => $product->id
        //     ]);
        // }


        if($request->has('extras')){
            foreach($request->extras as $extra){
                $issetEx = Extra::where('product_id', $product->id)->where('extra_id', $extra)->first();
                if(!$issetEx){
                    $extraObj = new Extra();
                    $extraObj->extra_id = $extra;
                    $extraObj->product_id = $product->id;
                    $extraObj->save();
                }
            }
        }

        if($request->has('drinks')){
            foreach($request->drinks as $drink){
                $issetDr = Drink::where('product_id', $product->id)->where('drink_id', $drink)->first();
                if(!$issetDr){
                    $drinkObj = new Drink();
                    $drinkObj->drink_id = $drink;
                    $drinkObj->product_id = $product->id;
                    $drinkObj->save();
                }
            }
        }

        if($request->has('options')){
            foreach($request->options as $option){
                $issetDr = ProductOption::where('product_id', $product->id)->where('option_id', $option)->first();
                if(!$issetDr){
                    $optionObj = new ProductOption();
                    $optionObj->option_id = $option;
                    $optionObj->product_id = $product->id;
                    $optionObj->save();
                }
            }
        }

        userLogs([
            'model' => '\App\Models\Product',
            'model_id' => $product->id,
            'description_ar' => 'اضافة منتج جديد',
            'description_en' => 'Add New Product',
            'status' => 'create'
        ]);

        return redirect(aurl('products'))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->with('images', 'category')->withCount('orders')->first();
        $products = Product::get();
        // return $product;
        return view('admin.products.view', [
            'title' => $product->name,
            'product' => $product,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->with('images', 'components')->first();
        $extras = Extra::where('product_id', $product->id)->pluck('extra_id')->toArray();
        $drinks = Drink::where('product_id', $product->id)->pluck('drink_id')->toArray();
        $product_options = ProductOption::where('product_id', $product->id)->pluck('option_id')->toArray();

        $options = Option::get();

        foreach($product->extras as $extra){
            $extra->extra = Product::whereId($extra->extra_id)->select([
                'id',
                'name_'.app()->getLocale(),
                'description_'.app()->getLocale(),
            ])->first();
        }

        foreach($product->drinks as $drink){
            $drink->drink = Product::whereId($drink->drink_id)->select([
                'id',
                'name_'.app()->getLocale(),
                'description_'.app()->getLocale(),
            ])->first();
        }

        // return $product;

        $products = Product::get();
        

        return view('admin.products.edit', [
            'title' => $product->name,
            'product' => $product,
            'products' => $products,
            'extras' => $extras,
            'drinks' => $drinks,
            'options' => $options,
            'product_options' => $product_options,
            'categories' => Category::orderBy('name_' . lang(), 'asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $product = Product::find($id);
        $request->validate([
            'name_ar'           => 'required',
            'name_en'           => 'required',
            'category_id'       => 'required',
            'description_ar'    => 'required',
            'description_en'    => 'required',
            'price'         => 'required',
            "images"            => "nullable|array|min:1",
            "images.*"          => "nullable|image|mimes:jpeg,png,jpg,webp",
        ], [], [
            'name_ar'           => trans('admin.Name Ar'),
            'name_en'           => trans('admin.Name En'),
            'category_id'       => trans('admin.Category'),
            'description_ar'    => trans('admin.Description Ar'),
            'description_en'    => trans('admin.Description En'),
            'price'         => trans('admin.Price'),
            'images'            => trans('admin.Images'),
        ]);

        if(!$request->has('extra_is_required')){
            $request['extra_min_required'] = 0;
        }

        if(!$request->has('drink_is_required')){
            $request['drink_min_required'] = 0;
        }

        if(!$request->has('option_is_required')){
            $request['option_min_required'] = 0;
        }

        $product = Product::where('id', $id)->first();
        $product->name_ar = $request->name_ar;
        $product->name_en = $request->name_en;
        $product->category_id = $request->category_id;
        $product->description_ar = $request->description_ar;
        $product->description_en = $request->description_en;
        $product->price = $request->price;
        $product->min_extras = ($request->extra_min_required && $request->extra_min_required != '')?$request->extra_min_required:0;
        $product->min_drinks = ($request->drink_min_required && $request->drink_min_required != '')?$request->drink_min_required:0;
        $product->min_options = ($request->option_min_required && $request->option_min_required != '')?$request->option_min_required:0;
        $product->save();

        if ($request->hasFile('images')) {
            ini_set('memory_limit', '-1');
            $files = $request->file('images');
            $image_path = date("Y-m-d") . '/';
            foreach ($files as $file) {
                $image_extension = $file->getClientOriginalExtension();
                $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
                File::makeDirectory(public_path('storage/products/' . $image_path), $mode = 0777, true, true);
                Image::make($file)
                    ->resize(650, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('storage/products/' . $image_path) . $image_imageName, 90);
                $image = new Media();
                $image->filename = $image_imageName;
                $image->mime = $file->getClientMimeType();
                $image->mediaable_id = $product->id;
                $image->mediaable_type = 'App\Models\Product';
                $image->url = url('') . '/storage/products/' . $image_path . $image_imageName;
                $image->save();
            }
        }

        // Component::where('product_id', $product->id)->delete();
        // foreach($request->components as $component){
        //     Component::create([
        //         'name' => $component,
        //         'product_id' => $product->id
        //     ]);
        // }
        
        if($request->has('extras')){
            Extra::where('product_id', $product->id)->delete();
            foreach($request->extras as $extra){
                $extraObj = new Extra();
                $extraObj->extra_id = $extra;
                $extraObj->product_id = $product->id;
                $extraObj->save();
            }
        }

        if($request->has('drinks')){
            Drink::where('product_id', $product->id)->delete();
            foreach($request->drinks as $drink){
                $drinkObj = new Drink();
                $drinkObj->drink_id = $drink;
                $drinkObj->product_id = $product->id;
                $drinkObj->save();
            }
        }

        if($request->has('options')){
            ProductOption::where('product_id', $product->id)->delete();
            foreach($request->options as $option){
                $optionObj = new ProductOption();
                $optionObj->option_id = $option;
                $optionObj->product_id = $product->id;
                $optionObj->save();
            }
        }

        if ($request->has('delete_images')) {
            $files = $request->delete_images;
            foreach ($files as $file) {
                $image = Media::where('id', $file)->first();
                if ($image) {
                    File::delete(public_path(str_replace(url(""), "", $image->url)));
                    $image->delete();
                }
            }
        }

        userLogs([
            'model' => '\App\Models\Product',
            'model_id' => $product->id,
            'description_ar' => 'تحديث بيانات المنتج',
            'description_en' => 'Update Product Details',
            'status' => 'update'
        ]);

        return redirect(aurl('products'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::find($request->product_id);
        if ($product) {
            $product->delete();
        }
        userLogs([
            'model' => '\App\Models\Product',
            'model_id' => $request->product_id,
            'description_ar' => 'حذف المنتج',
            'description_en' => 'Delete Product',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }

    public function generateSlug($slug, $id)
    {
        $data = Product::where('slug', $slug)->first();
        if ($data) {
            return $slug . "." . $id;
        } else {
            return $slug;
        }
    }
}
