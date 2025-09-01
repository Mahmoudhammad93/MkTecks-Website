<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.team.index', [
            'title' => trans('admin.Team'),
            'team' => Team::with('avatar')->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team.create', [
            'title' => trans('admin.Add New Employee')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position_ar'           => 'required',
            'position_en'           => 'required',
            'name'    => 'required',
            "image"            => "required|min:1",
        ], [], [
            'position_ar'           => trans('admin.Position Ar'),
            'position_en'           => trans('admin.Position En'),
            'name'    => trans('admin.Name'),
            'image'            => trans('admin.Image'),
        ]);

        $employee = Team::create([
            'position_ar' => $request->position_ar,
            'position_en' => $request->position_en,
            'name' => $request->name,
            'status' => $request->status
        ]);

        if ($request->hasFile('image')) {
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_path = date("Y-m-d") . '/';
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            File::makeDirectory(public_path('storage/team/' . $image_path), $mode = 0777, true, true);
            $file->move('storage/team/' . $image_path, $image_imageName);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->mediaable_id = $employee->id;
            $image->mediaable_type = 'App\Models\Team';
            $image->url = url('') . '/storage/team/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => '\App\Models\Team',
            'model_id' => $employee->id,
            'description_ar' => 'اضافة منتج خدمة',
            'description_en' => 'Add New Service',
            'status' => 'create'
        ]);

        return redirect(aurl('team'))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.team.edit', [
            'title' => trans('admin.Edit'),
            'employee' => Team::with('avatar')->find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'position_ar'           => 'required',
            'position_en'           => 'required',
            'name'    => 'required',
        ], [], [
            'position_ar'           => trans('admin.Position Ar'),
            'position_en'           => trans('admin.Position En'),
            'name'    => trans('admin.Name'),
        ]);


        $employee = Team::find($id);
        $employee->position_ar = $request->position_ar;
        $employee->position_en = $request->position_en;
        $employee->name = $request->name;
        $employee->status = $request->status;
        $employee->save();

        if ($request->hasFile('image')) {
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_path = date("Y-m-d") . '/';
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            File::makeDirectory(public_path('storage/team/' . $image_path), $mode = 0777, true, true);
            $file->move('storage/team/' . $image_path, $image_imageName);
            $image = Media::find($employee->id);
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->mediaable_id = $employee->id;
            $image->mediaable_type = 'App\Models\Team';
            $image->url = url('') . '/storage/team/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => '\App\Models\Team',
            'model_id' => $employee->id,
            'description_ar' => 'اضافة منتج خدمة',
            'description_en' => 'Add New Service',
            'status' => 'create'
        ]);

        return redirect(aurl('team'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $service = Team::find($request->id);
        if ($service) {
            $service->delete();
            Team::where('id', $request->category_id)->delete();
        }
        userLogs([
            'model' => '\App\Models\Category',
            'model_id' => $request->category_id,
            'description_ar' => 'مسح القسم',
            'description_en' => 'Delete Category',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }
}
