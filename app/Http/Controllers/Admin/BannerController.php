<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Banner;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banners.index', [
            'title' => trans('admin.All Banners'),
            'banners' => Banner::latest()->with('media')->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create', [
            'title' => trans('admin.Add New Banner'),
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
            'title_ar'          => 'nullable',
            'title_en'          => 'nullable',
            'link'          => 'nullable',
            'image'          => 'required|image|mimes:jpeg,png,jpg,webp',
        ], [], [
            'title_ar'          => trans('admin.Title Ar'),
            'title_en'          => trans('admin.Title En'),
            'link'          => trans('admin.Link'),
            'image'          => trans('admin.Image'),
        ]);
        $banner = new Banner();
        $banner->title_ar = $request->title_ar;
        $banner->title_en = $request->title_en;
        $banner->description_ar = $request->description_ar;
        $banner->description_en = $request->description_en;
        $banner->link = $request->link;
        $banner->clicks = 0;
        $banner->save();

        if ($request->hasFile('image')) {
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            $image_path = date("Y-m-d") . '/';
            File::makeDirectory(public_path('storage/banners/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/banners/' . $image_path) . $image_imageName, 90);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->type = 'image';
            $image->mediaable_id = $banner->id;
            $image->mediaable_type = 'App\Models\Banner';
            $image->url = url('') . '/storage/banners/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => 'App\Models\Banner',
            'model_id' => $banner->id,
            'description_ar' => 'اضافة اعلان يافطة جديد',
            'description_en' => 'Add New Banner Ad',
            'status' => 'create'
        ]);

        return redirect(aurl('banners'))->with('success', 'operation success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::where('id', $id)->with('media')->first();
        return view('admin.banners.edit', [
            'title' => $banner->title,
            'banner' => $banner
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
            'title_ar'          => 'nullable',
            'title_en'          => 'nullable',
            'link'          => 'nullable',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ], [], [
            'title_ar'          => trans('admin.Title Ar'),
            'title_en'          => trans('admin.Title En'),
            'link'          => trans('admin.Link'),
            'image'          => trans('admin.Image'),
        ]);

        $banner = Banner::where('id', $id)->with('media')->first();
        $banner->title_ar = $request->title_ar;
        $banner->title_en = $request->title_en;
        $banner->description_ar = $request->description_ar;
        $banner->description_en = $request->description_en;
        $banner->link = $request->link;
        $banner->clicks = 0;
        $banner->save();

        if ($request->hasFile('image')) {
            if ($banner->media()->exists()) {
                $data = Media::where('id', $banner->media->id)->first();
                if ($data) {
                    File::delete(public_path(str_replace(url(""), "", $data->url)));
                    $data->delete();
                }
            }
            ini_set('memory_limit', '-1');
            $file = $request->file('image');
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            $image_path = date("Y-m-d") . '/';
            File::makeDirectory(public_path('storage/banners/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/banners/' . $image_path) . $image_imageName, 90);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->type = 'image';
            $image->mediaable_id = $banner->id;
            $image->mediaable_type = 'App\Models\Banner';
            $image->url = url('') . '/storage/banners/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => '\App\Models\Banner',
            'model_id' => $banner->id,
            'description_ar' => 'تعديل بيانات اعلان يافطة',
            'description_en' => 'Update Banner Details',
            'status' => 'update'
        ]);

        return redirect(aurl('banners'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $banner = Banner::where('id', $request->banner_id)->with('media')->first();
        if ($banner) {
            if ($banner->media()->exists()) {
                $data = Media::where('id', $banner->media->id)->first();
                if ($data) {
                    File::delete(public_path(str_replace(url(""), "", $data->url)));
                    $data->delete();
                }
            }
            $banner->delete();
        }
        userLogs([
            'model' => '\App\Models\Banner',
            'model_id' => $request->banner_id,
            'description_ar' => 'حذف اعلان سلايد',
            'description_en' => 'Delete Banner',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }
}
