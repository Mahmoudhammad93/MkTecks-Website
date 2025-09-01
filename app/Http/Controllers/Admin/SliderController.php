<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sliders.index', [
            'title' => trans('admin.All Sliders'),
            'sliders' => Slider::latest()->with('media')->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sliders.create', [
            'title' => trans('admin.Add New Slider'),
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
        if(!$request->video && !$request->image){
            return back()->with('faild','You Must Select Image Or Vide');
        }

        $slider = new Slider();
        $slider->url = $request->url;
        $slider->status = $request->status;
        $slider->type = $request->type;
        $slider->save();

        if ($request->type == "video") {
            $file = $request->file('video');
            ini_set('memory_limit', '-1');
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            $image_path = date("Y-m-d") . '/';
            File::makeDirectory(public_path('storage/sliders/videos/' . $image_path), $mode = 0777, true, true);
            $file->move(public_path('storage/sliders/videos/' . $image_path), $image_imageName);
            $fileUrl = url('') . '/storage/sliders/videos/' . $image_path . $image_imageName;
            $fileMime = $file->getClientMimeType();
            $fileName = $image_imageName;

            $image = new Media();
            $image->filename = $fileName;
            $image->mime = $fileMime;
            $image->type = 'video';
            $image->mediaable_id = $slider->id;
            $image->mediaable_type = 'App\Models\Slider';
            $image->url = $fileUrl;
            $image->save();
        } else {
            if ($request->hasFile('image')) {
                ini_set('memory_limit', '-1');
                $file = $request->file('image');
                $image_extension = $file->getClientOriginalExtension();
                $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
                $image_path = date("Y-m-d") . '/';
                File::makeDirectory(public_path('storage/sliders/' . $image_path), $mode = 0777, true, true);
                Image::make($file)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('storage/sliders/' . $image_path) . $image_imageName, 90);
                $image = new Media();
                $image->filename = $image_imageName;
                $image->mime = $file->getClientMimeType();
                $image->type = 'image';
                $image->mediaable_id = $slider->id;
                $image->mediaable_type = 'App\Models\Slider';
                $image->url = url('') . '/storage/sliders/' . $image_path . $image_imageName;
                $image->save();
            }
        }

        userLogs([
            'model' => '\App\Models\Slider',
            'model_id' => $slider->id,
            'description_ar' => 'اضافة اعلان سلايد جديد',
            'description_en' => 'Add New Slider',
            'status' => 'create'
        ]);

        return redirect(aurl('sliders'))->with('success', 'operation success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::where('id', $id)->with('media')->first();
        return view('admin.sliders.edit', [
            'title' =>$slider->title,
            'slider' => $slider
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
            'url'          => 'nullable',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp',
        ], [], [
            'url'          => trans('admin.Link'),
            'image'          => trans('admin.Image'),
        ]);

        $slider = Slider::where('id', $id)->with('image')->first();
        $slider->url = $request->url;
        $slider->status = $request->status;
        $slider->save();

        if ($request->hasFile('image')) {
            if ($slider->image()->exists()) {
                $data = Media::where('id', $slider->image->id)->first();
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
            File::makeDirectory(public_path('storage/sliders/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('storage/sliders/' . $image_path) . $image_imageName, 90);
            $image = new Media();
            $image->filename = $image_imageName;
            $image->mime = $file->getClientMimeType();
            $image->type = 'image';
            $image->mediaable_id = $slider->id;
            $image->mediaable_type = 'App\Models\Slider';
            $image->url = url('') . '/storage/sliders/' . $image_path . $image_imageName;
            $image->save();
        }

        userLogs([
            'model' => 'App\Models\Slider',
            'model_id' => $slider->id,
            'description_ar' => 'تعديل بيانات اعلان سلايد',
            'description_en' => 'Edit Slider Details',
            'status' => 'update'
        ]);

        return redirect(aurl('sliders'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $slider = Slider::where('id', $request->slider_id)->with('media')->first();
        if ($slider) {
            if ($slider->media()->exists()) {
                $data = Media::where('id', $slider->media->id)->first();
                if ($data) {
                    File::delete(public_path(str_replace(url(""), "", $data->url)));
                    $data->delete();
                }
            }
            $slider->delete();
        }
        userLogs([
            'model' => '\App\Models\Slider',
            'model_id' => $request->slider_id,
            'description_ar' => 'حذف اعلان سلايد',
            'description_en' => 'Delete Slider',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }
}
