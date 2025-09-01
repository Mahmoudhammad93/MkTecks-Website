<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.galleries.index', [
            'title' => trans('admin.All Images'),
            'galleries' => Gallery::latest()->with('media')->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.galleries.create', [
            'title' => trans('admin.Add New Image'),
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
            'title_ar'          => 'required',
            'title_en'          => 'required',
            'icon'          => 'required',
            'link'          => 'required',
            'image'          => 'required|image|mimes:jpeg,png,jpg,webp',
        ], [], [
            'title_ar'          => trans('admin.Title Ar'),
            'title_en'          => trans('admin.Title En'),
            'icon'          => trans('admin.Type'),
            'link'          => trans('admin.Link'),
            'image'          => trans('admin.Image'),
        ]);

        $gallery = new Gallery();
        $gallery->title_ar = $request->title_ar;
        $gallery->title_en = $request->title_en;
        $gallery->icon = $request->icon;
        $gallery->link = $request->link;
        $gallery->clicks = 0;
        $gallery->save();

        if ($request->type == "video") {
            $file = $request->file('video');
            ini_set('memory_limit', '-1');
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            $image_path = date("Y-m-d") . '/';
            File::makeDirectory(public_path('storage/galleries/videos/' . $image_path), $mode = 0777, true, true);
            $file->move(public_path('storage/galleries/videos/' . $image_path), $image_imageName);
            $fileUrl = url('') . '/storage/galleries/videos/' . $image_path . $image_imageName;
            $fileMime = $file->getClientMimeType();
            $fileName = $image_imageName;

            $image = new Media();
            $image->filename = $fileName;
            $image->mime = $fileMime;
            $image->type = 'video';
            $image->mediaable_id = $gallery->id;
            $image->mediaable_type = 'App\Models\Gallery';
            $image->url = $fileUrl;
            $image->save();
        } else {
            if ($request->hasFile('image')) {
                ini_set('memory_limit', '-1');
                $file = $request->file('image');
                $image_extension = $file->getClientOriginalExtension();
                $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
                $image_path = date("Y-m-d") . '/';
                File::makeDirectory(public_path('storage/galleries/' . $image_path), $mode = 0777, true, true);
                Image::make($file)
                    ->resize(720, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('storage/galleries/' . $image_path) . $image_imageName, 90);
                $image = new Media();
                $image->filename = $image_imageName;
                $image->mime = $file->getClientMimeType();
                $image->type = 'image';
                $image->mediaable_id = $gallery->id;
                $image->mediaable_type = 'App\Models\Gallery';
                $image->url = url('') . '/storage/galleries/' . $image_path . $image_imageName;
                $image->save();
            }
        }

        userLogs([
            'model' => '\App\Models\Gallery',
            'model_id' => $gallery->id,
            'description_ar' => 'اضافة صورة جديدة للمعرض',
            'description_en' => 'Add New Gallery Image',
            'status' => 'create'
        ]);

        return redirect(aurl('galleries'))->with('success', 'operation success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Gallery::where('id', $id)->with('media')->first();
        return view('admin.galleries.edit', [
            'title' => $gallery->title,
            'gallery' => $gallery
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
            'title_ar'          => 'required',
            'title_en'          => 'required',
            'icon'          => 'required',
            'link'          => 'required',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ], [], [
            'title_ar'          => trans('admin.Title Ar'),
            'title_en'          => trans('admin.Title En'),
            'icon'          => trans('admin.Type'),
            'link'          => trans('admin.Link'),
            'image'          => trans('admin.Image'),
        ]);

        $gallery = Gallery::where('id', $id)->with('media')->first();
        $gallery->title_ar = $request->title_ar;
        $gallery->title_en = $request->title_en;
        $gallery->icon = $request->icon;
        $gallery->link = $request->link;
        $gallery->save();

        if ($request->hasFile('image')) {
            if ($gallery->media()->exists()) {
                $data = Media::where('id', $gallery->media->id)->first();
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
            File::makeDirectory(public_path('storage/galleries/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(720, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/galleries/' . $image_path) . $image_imageName, 90);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->type = 'image';
            $image->mediaable_id = $gallery->id;
            $image->mediaable_type = 'App\Models\Gallery';
            $image->url = url('') . '/storage/galleries/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => 'App\Models\Gallery',
            'model_id' => $gallery->id,
            'description_ar' => 'تعديل بيانات صور المعرض',
            'description_en' => 'Edit Gallery Image',
            'status' => 'update'
        ]);

        return redirect(aurl('galleries'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $gallery = gallery::where('id', $request->gallery_id)->with('media')->first();
        if ($gallery) {
            if ($gallery->media()->exists()) {
                $data = Media::where('id', $gallery->media->id)->first();
                if ($data) {
                    File::delete(public_path(str_replace(url(""), "", $data->url)));
                    $data->delete();
                }
            }
            $gallery->delete();
        }
        userLogs([
            'model' => '\App\Models\Gallery',
            'model_id' => $request->gallery_id,
            'description_ar' => 'حذف صورة المعرض',
            'description_en' => 'Delete Gallery Image',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }
}
