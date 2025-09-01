<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Service::with('image')->paginate(30);
        return view('admin.services.index', [
            'title' => trans('admin.All Services'),
            'services' => Service::with('image')->orderBy('order', 'asc')->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create', [
            'title' => trans('admin.Add New Service')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'title_ar'           => 'required',
            'title_en'           => 'required',
            'description_ar'    => 'required',
            'description_en'    => 'required',
            "image"            => "required|min:1",
        ], [], [
            'title_ar'           => trans('admin.Title Ar'),
            'title_en'           => trans('admin.Title En'),
            'description_ar'    => trans('admin.Description Ar'),
            'description_en'    => trans('admin.Description En'),
            'image'            => trans('admin.Image'),
        ]);

        $service = Service::create([
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'order' => $request->order,
            'status' => $request->status
        ]);

        if ($request->hasFile('image')) {
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_path = date("Y-m-d") . '/';
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            File::makeDirectory(public_path('storage/services/' . $image_path), $mode = 0777, true, true);
            $file->move('storage/services/' . $image_path, $image_imageName);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->mediaable_id = $service->id;
            $image->mediaable_type = 'App\Models\Service';
            $image->url = url('') . '/storage/services/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => '\App\Models\Service',
            'model_id' => $service->id,
            'description_ar' => 'اضافة منتج خدمة',
            'description_en' => 'Add New Service',
            'status' => 'create'
        ]);

        return redirect(aurl('services'))->with('success', 'operation success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::with('image')->find($id);
        return view('admin.services.edit', [
            'title' => $service->title,
            'service' => $service
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
        ], [], [
            'title_ar'           => trans('admin.Title Ar'),
            'title_en'           => trans('admin.Title En'),
            'description_ar'    => trans('admin.Description Ar'),
            'description_en'    => trans('admin.Description En'),
        ]);

        $service = Service::find($id);
        $service->title_ar = $request->title_ar;
        $service->title_en = $request->title_en;
        $service->description_ar = $request->description_ar;
        $service->description_en = $request->description_en;
        $service->order = $request->order;
        $service->status = $request->status;
        $service->save();

        if ($request->hasFile('image')) {
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_path = date("Y-m-d") . '/';
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            File::makeDirectory(public_path('storage/services/' . $image_path), $mode = 0777, true, true);
            $file->move('storage/services/' . $image_path, $image_imageName);
            $image = Media::find($service->id);
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->mediaable_id = $service->id;
            $image->mediaable_type = 'App\Models\Service';
            $image->url = url('') . '/storage/services/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => '\App\Models\Service',
            'model_id' => $service->id,
            'description_ar' => 'اضافة منتج خدمة',
            'description_en' => 'Add New Service',
            'status' => 'create'
        ]);

        return redirect(aurl('services'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $service = Service::find($request->id);
        if ($service) {
            $service->delete();
            Service::where('id', $request->category_id)->delete();
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
