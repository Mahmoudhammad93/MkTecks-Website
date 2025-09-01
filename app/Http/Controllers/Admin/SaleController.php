<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sales.index',[
            'title'=>trans('admin.All Sales'),
            'sales'=>Order::latest()->with('products')->withCount('products')->paginate(50)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function today()
    {
        return view('admin.sales.today',[
            'title'=>trans('admin.Sales Today'),
            'sales'=>Order::latest()->with('products')->whereDate('created_at', date('Y-m-d'))->withCount('products')->paginate(50)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function week()
    {
        return view('admin.sales.week',[
            'title'=>trans('admin.Sales Week'),
            'sales'=>Order::whereBetween('created_at', [Carbon::today()->startOfWeek(), Carbon::today()->endOfWeek()])->latest()->with('products')->withCount('products')->paginate(50)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function month()
    {
        return view('admin.sales.month',[
            'title'=>trans('admin.Sales Month'),
            'sales'=>Order::whereBetween('created_at', [Carbon::today()->startOfMonth(), Carbon::today()->endOfMonth()])->latest()->with('products')->withCount('products')->paginate(50)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function year()
    {
        return view('admin.sales.year',[
            'title'=>trans('admin.Yearly Sales'),
            'sales'=>Order::latest()->with('products')->whereYear('created_at', date('Y'))->withCount('products')->paginate(50)
        ]);
    }

}
