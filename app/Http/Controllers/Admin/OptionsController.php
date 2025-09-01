<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();

        return view('admin.options.index', [
            'title' => trans('admin.Options'),
            'options' => Option::paginate(30),
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.options.create',[
            'title' => trans('admin.Create New Option')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'status' => 'required'
        ]);

        Option::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'status' => $request->status,
        ]);

        return redirect(aurl('options'))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $option = Option::with(['properties' => function($q){
            $q->select([
                'id',
                'option_id',
                'name_ar',
                'name_en',
                'name_'.app()->getLocale().' as name',
                'price',
                'status'
            ]);
        }])->select([
            'id',
            'name_'.app()->getLocale().' as name',
            'status'
        ])->find($id);

        return view('admin.options.view', [
            'title' => trans('admin.View Option'),
            'option' => $option
        ]);
    }

    public function assign(Request $request, $id){
        $assigned = ProductOption::where('product_id', $request->product_id)->where('option_id', $id)->first();
        if($assigned){
            return redirect(aurl('options'))->with('faild', 'Oops! This option already assigned on this product');
        }

        ProductOption::create([
            'product_id' => $request->product_id,
            'option_id' => $id
        ]);

        return redirect(aurl('options'))->with('success', 'Option assigned successfuly');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // return Option::find($id);
        return view('admin.options.edit', [
            'title' => trans('admin.Edit Option'),
            'option' => Option::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'status' => 'required'
        ]);

        $option = Option::find($id);

        $option->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'status' => $request->status,
        ]);

        return redirect(aurl('options'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Option::whereId($id)->delete();
        return redirect()->back();
    }
}
