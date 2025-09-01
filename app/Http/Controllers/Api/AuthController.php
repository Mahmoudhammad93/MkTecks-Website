<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $validation = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users,mobile',
            'password' => 'required|min:8',
            'confirm_password' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'status' => 'Fail',
                'data' => $validation->messages()
            ]);
        }

        $user = new User();
        $user->name = $request->full_name;
        $user->is_guest = 0;
        $user->email = $request->email;
        $user->mobile = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        // if (!Auth::attempt($request->only('email', 'password'))) {
        //     return response()->json(['status' => 'failed', 'message' => 'Invalid login details']);
        // }

        $user = User::where('email', $request['email'])->firstOrFail();


        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name?$request->device_name:'auth_token')->plainTextToken;
        return response()->json(['status'=>'success','access_token' => $token,'token_type' => 'Bearer', 'name' => $user->name]);
    }
}
