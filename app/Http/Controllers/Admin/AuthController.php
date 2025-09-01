<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('admin.auth.login');
    }

    public function auth(Request $request){
        $data = $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if($request->remember == "on"){
            $remember = true;
        }else{
            $remember = false;
        }

        if(Auth::attempt($data,$remember)){
            userLogs([
                'model'=>'\App\Models\User' ,
                'model_id'=>Auth::user()->id ,
                'description_ar'=>'تسجيل الدخول',
                'description_en'=>'Login',
                'status'=>'login'
            ]);
            return redirect(aurl('dashboard'))->with('success','login success');
        }
        return redirect(aurl('login'))->with('faild','login faild');

    }

    public function logout(){
        userLogs([
            'model'=>'\App\Models\User' ,
            'model_id'=>Auth::user()->id ,
            'description_ar'=>'تسجيل خروج',
            'description_en'=>'Logout',
            'status'=>'logout'
        ]);
        Auth::logout();
        return redirect(aurl('login'));
    }
}
