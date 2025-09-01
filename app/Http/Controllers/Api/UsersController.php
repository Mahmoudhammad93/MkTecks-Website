<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function Profile()
    {    
        return response()->json([
            'status' => 'success',
            'data' => Auth::user()
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function profileUpdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        $myDate = date('m/d/Y');
        $date = Carbon::createFromFormat('m/d/Y', $myDate);
        $month = $date->format('F');
        $year = $date->format('Y');
        if($request->hasFile('image')){
            $file = $request->image;
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.' . $extension;
            $file->move(public_path('storage/Users/'.$month.$year), $filename);
            $user->image = 'Users/'.$month.$year.'/'.$filename;
        }
        if($request->has('full_name')){
            $user->name = $request->full_name;
        }
        if($request->has('email')){
            $user->email = $request->email;
        }
        if($request->has('phone')){
            $user->mobile = $request->phone;
        }
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
