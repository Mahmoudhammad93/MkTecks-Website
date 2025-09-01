<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.notifications.index', [
            'title' => trans('admin.Notifications'),
            'notifications' => Notification::with('user.profile')->where('model', '!=', '\App\Models\Order')->latest()->paginate(50)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_orders()
    {
        return view('admin.notifications.orders', [
            'title' => trans('admin.Notifications'),
            'notifications' => Notification::with('user.profile')->where('model', '\App\Models\Order')->latest()->paginate(50)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function read($type)
    {
        try {
            if ($type == "order") {
                Notification::where('model', '\App\Models\Order')->where('admin_read_at', null)->update([
                    'admin_read_at' => Carbon::now()
                ]);
            } else {
                Notification::where('model', '!=', '\App\Models\Order')->where('admin_read_at', null)->update([
                    'admin_read_at' => Carbon::now()
                ]);
            }
            return responseSuccessMessage(trans('app.Operation Success'));
        } catch (\Exception $ex) {
            return responseError($ex);
        }
    }

    public function notify()
    {
        try {
            $notifications = Notification::where('model', '\App\Models\Order')
                ->where('is_admin_notify', 0)
                ->take(5)
                ->get();

                foreach($notifications as $notify){
                    Notification::where('id',$notify->id)->update([
                        'is_admin_notify'=>1
                    ]);
                }
            if ($notifications->count() > 0) {
                return responseSuccess(trans('app.Operation Success'), $notifications);
            }else{
                return responseValid(trans('admin.No Data Found'));
            }
        } catch (\Exception $ex) {
            return responseError($ex);
        }
    }

    public function board_notify()
    {
        try {
            $notifications = Notification::where('model', '\App\Models\BoardOrder')
                ->where('is_admin_notify', 0)
                ->get();

                foreach($notifications as $notify){
                    Notification::where('id',$notify->id)->update([
                        'is_admin_notify'=>1
                    ]);
                }
            if ($notifications->count() > 0) {
                return responseSuccess(trans('app.Operation Success'), $notifications);
            }else{
                return responseValid(trans('admin.No Data Found'));
            }
        } catch (\Exception $ex) {
            return responseError($ex);
        }
    }
}
