<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Setting;
use App\Models\UserDetail;
use App\Rules\Dimensions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{

    public function index()
    {
        return view('admin.settings.index', [
            'title' => trans('admin.Settings'),
            'setting' => Setting::first()
        ]);
    }

    public function about()
    {
        return view('admin.settings.about', [
            'title' => trans('admin.Terms'),
            'setting' => Setting::first()
        ]);
    }

    public function language($lang)
    {
        session()->put('lang', $lang);
        if (adminLogin()->details()->exists()) {
            UserDetail::where('user_id', adminLogin()->id)->update([
                'language' => $lang
            ]);
        } else {
            UserDetail::create([
                'user_id' => adminLogin()->id,
                'language' => $lang,
                'theme' => theme(),
            ]);
        }
        return back()->with('success', 'language change successful');
    }

    public function theme($theme)
    {
        try {
            session()->put('theme', $theme);
            if (adminLogin()->details()->exists()) {
                UserDetail::where('user_id', adminLogin()->id)->update([
                    'theme' => $theme
                ]);
            } else {
                UserDetail::create([
                    'user_id' => adminLogin()->id,
                    'language' => lang(),
                    'theme' => $theme,
                ]);
            }
            return responseSuccessMessage(trans('admin.operation success'));
        } catch (\Exception $ex) {
            return responseValid(trans('admin.Please Try Again'));
        }
    }

    public function update(Request $request)
    {
        // $request->validate([
        //     'logo' => ['image', new Dimensions(120, 120)],
        // ]);

        $setting = Setting::first();

        $setting->name_status = ($request->has('name_status'))?1:0;

        // return $request;

        if ($request->hasFile('logo')) {
            ini_set('memory_limit', '-1');
            $file = $request->file('logo');
            $image_extension = $file->getClientOriginalExtension();
            $image_imageName = date('mdYHis') . uniqid() . '.' . $image_extension;
            $image_path = date("Y-m-d") . '/';
            File::makeDirectory(public_path('storage/settings/' . $image_path), $mode = 0777, true, true);
            Image::make($file)
                ->save(public_path('storage/settings/' . $image_path) . $image_imageName, 90);

            $setting->logo = url('') . '/storage/settings/' . $image_path . $image_imageName;
        }

        // if($request->name_ar){
            $setting->name_ar = $request->name_ar;
        // }

        // if($request->name_en){
            $setting->name_en = $request->name_en;
        // }

        // if($request->email){
            $setting->email = $request->email;
        // }

        // if($request->phone){
            $setting->phone = $request->phone;
        // }

        // if($request->address_ar){
            $setting->address_ar = $request->address_ar;
        // }

        // if($request->address_en){
            $setting->address_en = $request->address_en;
        // }

        // if($request->description_ar){
            $setting->description_ar = $request->description_ar;
        // }

        // if($request->description_en){
            $setting->description_en = $request->description_en;
        // }

        // if($request->about_ar){
            $setting->about_ar = $request->about_ar;
        // }

        // if($request->about_en){
            $setting->about_en = $request->about_en;
        // }

        // if($request->whatsapp){
            $setting->whatsapp = $request->whatsapp;
        // }

        // if($request->facebook){
            $setting->facebook = $request->facebook;
        // }

        // if($request->instagram){
            $setting->instagram = $request->instagram;
        // }

        // if($request->twitter){
            $setting->twitter = $request->twitter;
        // }

        // if($request->snapchat){
            $setting->snapchat = $request->snapchat;
        // }

        // if($request->appstore){
            $setting->appstore = $request->appstore;
        // }

        // if($request->playstore){
            $setting->playstore = $request->playstore;
        // }


        // if($request->color){
            $setting->color = $request->color;
        // }

        $setting->header_message_ar = $request->header_message_ar;
        $setting->header_message_en = $request->header_message_en;
        $setting->header_title_ar = $request->header_title_ar;
        $setting->header_title_en = $request->header_title_en;
        $setting->header_description_ar = $request->header_description_ar;
        $setting->header_description_en = $request->header_description_en;


        $setting->save();

        return back()->with('success','operation success');
    }
}
