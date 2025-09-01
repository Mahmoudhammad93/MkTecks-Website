<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;

class AppController extends Controller
{

    public function paymentMethods(){
        return response()->json([
            'status' => 'success',
            'data' => PaymentMethod::with('image')->whereStatus(1)->get()
        ]);
    }

    public function branches(){
        return response()->json([
            'status' => 'success',
            'data' => Branch::whereStatus(1)->get()
        ]);
    }

    public function branch($id){
        $branch = Branch::whereStatus(1)->find($id);

        if(!$branch){
            return response()->json([
                'status' => 'faild',
                'message' => 'Branch not found'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $branch
        ]);
    }

    public function settings(){
        $settings = Setting::first();
        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
    }

    public function homeBanner(){
        $banner = Slider::with('image')->whereStatus(1)->first();

        // if(!$banner){
        //     return response()->json([
        //         'status' => 'faild',
        //         'message' => 'Banner not found'
        //     ]);
        // }

        return response()->json([
            'status' => 'success',
            'message' => $banner
        ]);
    }

}
