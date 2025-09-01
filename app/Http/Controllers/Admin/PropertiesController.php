<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Properity;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        return view('admin.options.properites.create', [
            'title' => trans('admin.Create Properity'),
            'id' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'price' => 'required',
            'status' => 'required'
        ]);

        Properity::create([
            'option_id' => $id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'status' => $request->status
        ]);

        return redirect(aurl('options/view/'.$id))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id, $prop_id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        $properity = Properity::find($prop_id);
        $properity->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect(aurl('options/view/'.$id))->with('success', 'operation success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
