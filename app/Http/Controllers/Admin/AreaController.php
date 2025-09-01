<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function city(Request $request){
        try{
            $areas = Area::where('city_id',$request->city_id)->orderBy('name_'.lang(),'asc')->get();
            return response([
                "success" => true,
                "message" => trans('api.areas'),
                "data"    => $areas,
            ],200);
        }catch(\Exception $ex){
            return response([
                "success" => false,
                "message" => $ex->getMessage(),
            ],200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delivery_create(Request $request)
    {
        $request->validate([
            'delivery'        => 'required',
        ], [], [
            'delivery'        => trans('admin.Price'),
        ]);

        Area::where('city_id',$request->city_id)->update([
            'delivery'=>$request->delivery,
        ]);

        userLogs([
            'model'=>'App\Models\City',
            'model_id'=>$request->city_id ,
            'description_ar'=>'تحديث سعر التوصيل للمناطق',
            'description_en'=>'Update Delivery Price For All Areas',
            'status'=>'update'
        ]);
        return redirect(aurl('cities/view/'.$request->city_id))->with('success','operation success');
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
            'name_ar'        => 'required',
            'name_en'        => 'required',
        ], [], [
            'name_ar'        => trans('admin.Name Ar'),
            'name_en'        => trans('admin.Name En'),
        ]);

        $area = new Area();
        $area->city_id = $request->city_id;
        $area->name_ar = $request->name_ar;
        $area->name_en = $request->name_en;
        $area->delivery = $request->delivery;
        $area->save();

        userLogs([
            'model'=>'App\Models\Area',
            'model_id'=>$area->id ,
            'description_ar'=>'انشاء منطقة جديد',
            'description_en'=>'Create New Area',
            'status'=>'create'
        ]);
        return redirect(aurl('cities/view/'.$request->city_id))->with('success','operation success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name_ar'        => 'required',
            'name_en'        => 'required',
        ], [], [
            'name_ar'        => trans('admin.Name Ar'),
            'name_en'        => trans('admin.Name En'),
        ]);

        $area = Area::where('id',$request->area_id)->with('city')->first();
        $area->name_ar = $request->name_ar;
        $area->name_en = $request->name_en;
        $area->delivery = $request->delivery;
        $area->save();

        userLogs([
            'model'=>'App\Models\Area',
            'model_id'=>$area->id ,
            'description_ar'=>'انشاء منطقة جديد',
            'description_en'=>'Create New Area',
            'status'=>'create'
        ]);
        return redirect(aurl('cities/view/'.$area->city_id))->with('success','operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $area = Area::where('id',$request->area_id)->first();
        if($area){
            userLogs([
                'model'=>'App\Models\Area',
                'model_id'=>$area->id ,
                'description_ar'=>'حذف المحافظة',
                'description_en'=>'Delete City',
                'status'=>'delete'
            ],$area);
            $area->delete();
        }
        return back()->with('success','operation success');
    }
}
