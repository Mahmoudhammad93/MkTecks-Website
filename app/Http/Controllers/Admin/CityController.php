<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cities.index',[
            'title'=>trans('admin.All Cities'),
            'cities'=>City::withCount('areas')->orderBy('name_'.lang(),'asc')->paginate(50)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create',[
            'title'=>trans('admin.Add New City'),
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
            'name_ar'        => 'required',
            'name_en'        => 'required',
        ], [], [
            'name_ar'        => trans('admin.Name Ar'),
            'name_en'        => trans('admin.Name En'),
        ]);

        $city = new City();
        $city->name_ar = $request->name_ar;
        $city->name_en = $request->name_en;
        $city->save();

        userLogs([
            'model'=>'App\Models\City',
            'model_id'=>$city->id ,
            'description_ar'=>'انشاء محافظة جديد',
            'description_en'=>'Create New City',
            'status'=>'create'
        ]);
        return redirect(aurl('cities'))->with('success','operation success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::where('id',$id)->withCount('areas')->first();
        $areas = Area::where('city_id',$city->id)->get();
        return view('admin.cities.view',[
            'title'=>$city->name,
            'city'=>$city,
            'areas'=>$areas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::where('id',$id)->first();
        return view('admin.cities.edit',[
            'title'=>$city->name,
            'city'=>$city
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
            'name_ar'        => 'required',
            'name_en'        => 'required',
        ], [], [
            'name_ar'        => trans('admin.Name Ar'),
            'name_en'        => trans('admin.Name En'),
        ]);

        $city = City::where('id',$id)->first();
        $city->name_ar = $request->name_ar;
        $city->name_en = $request->name_en;
        $city->save();

        userLogs([
            'model'=>'App\Models\City',
            'model_id'=>$city->id ,
            'description_ar'=>'تعديل المحافظة',
            'description_en'=>'Update City',
            'status'=>'update'
        ]);
        return redirect(aurl('cities'))->with('success','operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $city = City::where('id',$request->city_id)->first();
        if($city){
            userLogs([
                'model'=>'App\Models\City',
                'model_id'=>$city->id ,
                'description_ar'=>'حذف المحافظة',
                'description_en'=>'Delete City',
                'status'=>'delete'
            ],$city);
            $city->delete();
        }
        return back()->with('success','operation success');
    }
}
