<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->withCount('products')->paginate(30);
        return view('admin.orders.index', [
            'title' => trans('admin.All Orders'),
            'orders' => $orders
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function today()
    {
        $orders = Order::latest()->withCount('products')->whereDate('created_at', date('Y-m-d'))->paginate(30);
        return view('admin.orders.index', [
            'title' => trans('admin.Orders Today') . " - " .date('Y-m-d'),
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id', $id)->with(['products.product', 'branch' => function($q){
            $q->select([
                'id',
                'name_'.app()->getLocale().' as name',
                'address',
                'latitude',
                'longitude',
                'status',
                'created_at',
            ]);
        }])->first();
        // return $order;
        return view('admin.orders.view', [
            'title' => trans('admin.Order Details'),
            'order' => $order
        ]);
    }

    public function update(Request $request ,$id){
        Order::where('id',$id)->update([
            'status'=>$request->status
        ]);
        return back()->with('success','operation success');
    }

}
