<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('user_type','user')->latest()->paginate(30);
        return view('admin.users.index',[
            'title'=>trans('admin.All Users'),
            'users'=>$users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create',[
            'title'=>trans('admin.Add New User'),
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
            'name'          => 'required',
            'email'         => 'required|unique:users',
            'mobile'        => 'required|unique:users',
            'password'      => 'required|min:6',
        ], [], [
            'name'          => trans('admin.Name'),
            'email'         => trans('admin.Email'),
            'mobile'        => trans('admin.Mobile'),
            'password'      => trans('admin.Password'),
        ]);

        $user = new User();
        $user->user_type = "user";
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = bcrypt($request->password);
        $user->save();

        userLogs([
            'model'=>'\App\Models\User' ,
            'model_id'=>$user->id ,
            'description_ar'=>'اضافة مستخدم جديد',
            'description_en'=>'Add New User',
            'status'=>'create'
        ]);

        return redirect(aurl('users'))->with('success','operation success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit',[
            'title'=>$user->name,
            'user'=>$user
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
            'name'          => 'required',
            'email'         => 'required|unique:users,id,'.$id,
            'mobile'        => 'required|unique:users,id,'.$id,
        ], [], [
            'name'          => trans('admin.Name'),
            'email'         => trans('admin.Email'),
            'mobile'        => trans('admin.Mobile'),
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        userLogs([
            'model'=>'\App\Models\User' ,
            'model_id'=>$user->id ,
            'description_ar'=>'تعديل بيانات المستخدم',
            'description_en'=>'Update User Data',
            'status'=>'update'
        ]);
        return redirect(aurl('users'))->with('success','operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->user_id);
        if($user){
            $user->delete();
        }
        userLogs([
            'model'=>'\App\Models\User' ,
            'model_id'=>$request->user_id ,
            'description_ar'=>'مسح المستخدم',
            'description_en'=>'Delete User',
            'status'=>'delete'
        ]);
        return back()->with('success','operation success');
    }
}
