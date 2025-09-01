<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::paginate(10);
        // return $coupons;
        return view('admin.coupons.index', [
            'title' => trans('admin.All Coupons'),
            'coupons' => $coupons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.form', [
            'title' => trans('admin.Create Coupon'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'value' => 'required',
            'discount_type' => 'required'
        ]);
        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->value = $request->value;
        $coupon->discount_type = $request->discount_type;
        $coupon->min_total = $request->min_total;
        $coupon->usage_count = $request->usage_count;
        $coupon->usage_per_user = $request->usage_per_user;
        $coupon->save();

        return redirect()->route('admin.coupons');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupons.form', [
            'title' => trans('admin.Edit Coupon'),
            'coupon' => $coupon
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
        $request->validate([
            'code' => 'required|unique:coupons',
            'value' => 'required',
            'discount_type' => 'required'
        ]);

        $coupon = Coupon::find($id);
        $coupon->code = $request->code;
        $coupon->value = $request->value;
        $coupon->discount_type = $request->discount_type;
        $coupon->min_total = $request->min_total;
        $coupon->usage_count = $request->usage_count;
        $coupon->usage_per_user = $request->usage_per_user;
        $coupon->save();

        return redirect()->route('admin.coupons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::whereId($id)->delete();
        return redirect()->back();
    }
}
