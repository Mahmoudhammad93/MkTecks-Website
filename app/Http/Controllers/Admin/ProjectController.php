<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.projects.index', [
            'title' => trans('admin.Projects'),
            'projects' => Project::with('image')->orderBy('order', 'asc')->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create', [
            'title' => trans('Add New Project')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_ar'           => 'required',
            'title_en'           => 'required',
            'description_ar'    => 'required',
            'description_en'    => 'required',
            'url'    => 'required',
            "image"            => "required|min:1",
        ], [], [
            'title_ar'           => trans('admin.Title Ar'),
            'title_en'           => trans('admin.Title En'),
            'description_ar'    => trans('admin.Description Ar'),
            'description_en'    => trans('admin.Description En'),
            'url'    => trans('admin.URL'),
            'image'            => trans('admin.Image'),
        ]);

        $project = Project::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'order' => $request->order,
            'url' => $request->url,
            'status' => $request->status
        ]);

        if ($request->hasFile('image')) {
            foreach($request->image as $image){
                ini_set('memory_limit', '-1');
                $file = $image;
                $image_path = date("Y-m-d") . '/';
                $image_extension = $file->getClientOriginalExtension();
                $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
                File::makeDirectory(public_path('storage/projects/' . $image_path), $mode = 0777, true, true);
                $file->move('storage/projects/' . $image_path, $image_imageName);
                $image = Media::where('mediaable_id',$project->id)->first();
                $image->filename = $image_imageName;
                $image->mime = $file->getClientMimeType();
                $image->mediaable_id = $project->id;
                $image->mediaable_type = 'App\Models\Project';
                $image->url = url('') . '/storage/projects/' . $image_path . $image_imageName;
                $image->save();
            }
        }

        userLogs([
            'model' => '\App\Models\Project',
            'model_id' => $project->id,
            'description_ar' => 'اضافة منتج خدمة',
            'description_en' => 'Add New Project',
            'status' => 'create'
        ]);

        return redirect(aurl('projects'))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = Project::with('image')->find($id);
        // return $project;
        return view('admin.projects.edit', [
            'title' => $project->title,
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title_ar'           => 'required',
            'title_en'           => 'required',
            'description_ar'    => 'required',
            'description_en'    => 'required',
            'url'    => 'required'
        ], [], [
            'title_ar'           => trans('admin.Title Ar'),
            'title_en'           => trans('admin.Title En'),
            'description_ar'    => trans('admin.Description Ar'),
            'description_en'    => trans('admin.Description En'),
            'url'    => trans('admin.URL')
        ]);

        $project = Project::find($id);
        $project->title_ar = $request->title_ar;
        $project->title_en = $request->title_en;
        $project->description_ar = $request->description_ar;
        $project->description_en = $request->description_en;
        $project->order = $request->order;
        $project->url = $request->url;
        $project->status = $request->status;
        $project->save();

        if ($request->hasFile('image')) {
            foreach($request->image as $image){
                ini_set('memory_limit', '-1');
                $file = $image;
                $image_path = date("Y-m-d") . '/';
                $image_extension = $file->getClientOriginalExtension();
                $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
                File::makeDirectory(public_path('storage/projects/' . $image_path), $mode = 0777, true, true);
                $file->move('storage/projects/' . $image_path, $image_imageName);
                $image = Media::where('mediaable_id',$project->id)->first();
                $image->filename = $image_imageName;
                $image->mime = $file->getClientMimeType();
                $image->mediaable_id = $project->id;
                $image->mediaable_type = 'App\Models\Project';
                $image->url = url('') . '/storage/projects/' . $image_path . $image_imageName;
                $image->save();
            }
        }

        userLogs([
            'model' => '\App\Models\Project',
            'model_id' => $project->id,
            'description_ar' => 'اضافة منتج خدمة',
            'description_en' => 'Add New Project',
            'status' => 'create'
        ]);

        return redirect(aurl('projects'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $service = Project::find($request->id);
        if ($service) {
            $service->delete();
            Project::where('id', $request->category_id)->delete();
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
