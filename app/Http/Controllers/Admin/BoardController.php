<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\BoardOrder;
use App\Models\BoardOrderProduct;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.boards.index',[
            'title'=>trans('admin.All Boards'),
            'boards'=>Board::withCount('orders')->with('orders')->get()
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
        Board::truncate();
        for($i = 1 ; $i <= $request->number ; $i++){
            Board::create([
                'number'=>$i
            ]);
        }
        return back()->with('success','operation success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function new_orders()
    {
        return view('admin.boards.orders_new',[
            'title'=>trans('admin.New Orders'),
            'orders'=>BoardOrder::withCount('products')->where('payment_status','!=','paid')->where('order_status','!=','finished')->latest()->paginate(50)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function recent_orders()
    {
        return view('admin.boards.orders_recent',[
            'title'=>trans('admin.Recent Orders'),
            'orders'=>BoardOrder::where(['payment_status'=>'paid','order_status'=>'finished'])->latest()->withCount('products')->paginate(50)
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
        $board = Board::find($id);
        return view('admin.boards.orders_recent',[
            'title'=>trans('admin.Table Number').$board->number,
            'orders'=>BoardOrder::where('board_id',$id)->where(['payment_status'=>'paid','order_status'=>'finished'])->latest()->withCount('products')->paginate(50)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orders_view($id)
    {
        $order = BoardOrder::with('products.product.image')->where('id',$id)->first();
        return view('admin.boards.orders_view',[
            'title'=>trans('admin.Recent Orders'),
            'order'=>$order
        ]);
    }

    public function update(Request $request , $id){
        BoardOrder::where('id',$id)->update([
            'order_status'=>$request->status
        ]);
        BoardOrderProduct::where('board_order_id',$id)->update([
            'product_status'=>$request->status
        ]);
        return back()->with('success','operation success');
    }

    public function payment_update(Request $request , $id){
        BoardOrder::where('id',$id)->update([
            'payment_status'=>$request->payment_status
        ]);
        return back()->with('success','operation success');
    }

}
