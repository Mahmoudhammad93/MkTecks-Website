<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Branch;
use App\Models\BranchArea;
use App\Models\City;
use Illuminate\Http\Request;

class BranchsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.branches.index', [
            'title' => trans('admin.Branches'),
            'branches' => Branch::select([
                'id',
                'name_'.app()->getLocale().' as name',
                'address',
                'latitude',
                'longitude',
                'status',
                'created_at'
            ])->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branches.form', [
            'title' => trans('admin.Add New Branch'),
            'cities' => City::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'status' => 'required'
        ]);

        $requestData = $request->except(['_token']);
        $branch = new Branch();
        $branch->name_ar = $requestData['name_ar'];
        $branch->name_en = $requestData['name_en'];
        $branch->address = $requestData['address'];
        $branch->latitude = $requestData['latitude'];
        $branch->longitude = $requestData['longitude'];
        $branch->status = $requestData['status'];
        $branch->save();

        BranchArea::create([
            'branch_id' => $branch->id,
            'city_id' => json_encode($requestData['city_id']),
            'areas' => json_encode($requestData['areas'])
        ]);
        return redirect(aurl('branches'))->with('success', 'operation success');
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
        $row = BranchArea::where('branch_id', $id)->first();
        if(isset($row)){
            if(json_decode($row->city_id) && gettype(json_decode($row->city_id)) != 'string'){
                foreach(json_decode($row->city_id) as $city){
                    $cities[] = City::whereId($city)->first()->id;
                }
            }else{
                $cities = [json_decode($row->city_id)];
            }
            $areas_arr = json_decode($row->areas);
        }else{
            $cities = [];
            $areas_arr = [];
        }

        return view('admin.branches.form', [
            'title' => trans('admin.Branches'),
            'branch' => Branch::find($id),
            'cities' => City::get(),
            'city_arr' => $cities,
            'areas_arr' => $areas_arr
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'status' => 'required'
        ]);

        if(!$request->has('areas')){
            $request['areas'] = 0;
        }

        $requestData = $request->except(['_token']);


        $branch = Branch::find($id);
        $branch->update($requestData);
        $branchAreas = BranchArea::where('branch_id', $branch->id)->first();
        if(isset($branchAreas)){
            if($request->has('all_areas')){
                $branchAreas->city_id = json_encode('all');
                $branchAreas->areas = json_encode('all');
            }else{
                $branchAreas->city_id = json_encode($requestData['city_id']);
                $branchAreas->areas = json_encode($requestData['areas']);
            }
            $branchAreas->save();
        }else{
            BranchArea::create([
                'branch_id' => $branch->id,
                'city_id' => ($request->has('all_areas'))?json_encode('all'):json_encode($requestData['city_id']),
                'areas' => ($request->has('all_areas'))?json_encode('all'):json_encode($requestData['areas'])
            ]);
        }

        return redirect(aurl('branches'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Branch::whereId($id)->delete();
        return redirect()->back();
    }

    public function getBranchAreas(Request $request){
        foreach($request->cities as $city){
            $areas[] = Area::where('city_id', $city)->get();
        }
        $row = BranchArea::where('branch_id', $request->branch_id)->first();
        if($row){
            $areas_arr = json_decode($row->areas);
        }else{
            $areas_arr = [];
        }
        return response()->json([
            'status' => 'success',
            'areas' => $areas,
            'areas_arr' => $areas_arr
        ]);
    }
}
