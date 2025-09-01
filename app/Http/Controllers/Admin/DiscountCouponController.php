<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.coupons.index', [
            'title' => trans('admin.Discount Coupons'),
            'coupons' => DiscountCoupon::paginate(50)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create', [
            'title' => trans('admin.Add New Coupon'),
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
            'code'          => 'required|unique:discount_coupons',
            'limit'        => 'required',
            'end_at'      => 'required',
            "percentage"         => "required",
        ], [], [
            'code'         => trans('admin.Discount Coupon'),
            'limit'        => trans('admin.Maximum'),
            'end_at'      => trans('admin.End At'),
            'percentage'         => trans('admin.Percentage'),
        ]);

        $coupon = new DiscountCoupon();
        $coupon->limit = $request->limit;
        $coupon->code = $request->code;
        $coupon->end_at = Carbon::parse($request->end_at);
        $coupon->percentage = $request->percentage;
        $coupon->save();

        userLogs([
            'model' => '\App\Models\DiscountCoupon',
            'model_id' => $coupon->id,
            'description_ar' => 'اضافة كود خصم',
            'description_en' => 'Add New Discount Coupon',
            'status' => 'create'
        ]);

        return redirect(aurl('coupons'))->with('success', 'operation success');
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
        $coupon = DiscountCoupon::find($id);
        return view('admin.coupons.edit', [
            'title' => $coupon->code,
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
            'code'          => 'required|unique:discount_coupons,id,' . $id,
            'limit'        => 'required',
            'end_at'      => 'required',
            "percentage"         => "required",
        ], [], [
            'code'         => trans('admin.Discount Coupon'),
            'limit'        => trans('admin.Maximum'),
            'end_at'      => trans('admin.End At'),
            'percentage'         => trans('admin.Percentage'),
        ]);

        $coupon = DiscountCoupon::find($id);
        $coupon->limit = $request->limit;
        $coupon->code = $request->code;
        $coupon->end_at = Carbon::parse($request->end_at);
        $coupon->percentage = $request->percentage;
        $coupon->save();

        userLogs([
            'model' => '\App\Models\DiscountCoupon',
            'model_id' => $coupon->id,
            'description_ar' => 'تعديل بيانات كود الخصم',
            'description_en' => 'Update Discount Coupon Details',
            'status' => 'update'
        ]);

        return redirect(aurl('coupons'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $coupon = DiscountCoupon::find($request->coupon_id);
        if($coupon){
            $coupon->delete();
        }
        return back()->with('success', 'operation success');
    }
}
