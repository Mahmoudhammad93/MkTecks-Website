<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', $user->id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $addresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $request['area_id'] = 1;
        $request['apartment_no'] = 1;

        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
            'gov_id' => 'required',
            'region_id' => 'required',
            'title_name' => 'required',
            'street' => 'required',
            'block' => 'required',
            'building' => 'required',
            'avenue' => 'required',
            'flat' => 'required',
            'role' => 'required'
        ]);

        if($validation->fails()){
            return response()->json([
                'status' => 'Fail',
                'data' => $validation->messages()
            ]);
        }

        $address = Address::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $address
        ]);
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
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $request['user_id'] = $user->id;

        $address = Address::find($id);
        $address->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Address::find($id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'deleted success'
        ]);
    }

    public function cities(){
        $cities = City::get();
        return response()->json([
            'status' => 'success',
            'data' => $cities
        ]);
    }

    public function areas($city_id){
        $areas = Area::where('city_id', $city_id)->get();
        return response()->json([
            'status' => 'success',
            'data' => $areas
        ]);
    }
}
