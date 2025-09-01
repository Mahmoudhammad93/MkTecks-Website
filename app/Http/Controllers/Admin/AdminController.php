<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('user_type','admin')->latest()->paginate(30);
        return view('admin.admins.index',[
            'title'=>trans('admin.All Admins'),
            'admins'=>$admins
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $admins = User::onlyTrashed()->where('user_type', 'admin')->latest()->paginate(30);
        return view('admin.admins.deleted',[
            'title'=>trans('admin.All Deleted Admins'),
            'admins'=>$admins
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs($id = null)
    {
        if($id){
            $logs = AdminLog::where('user_id',$id)->whereHas('user')->with('user')->latest()->paginate(30);
        }else{
            $logs = AdminLog::with('user')->latest()->paginate(30);
        }
        return view('admin.admins.logs',[
            'title'=>trans('admin.Activity'),
            'logs'=>$logs,
            'user'=>User::find($id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('admin.admins.create',[
            'title'=>trans('admin.Add New Admin'),
            'roles' => $roles
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
            'mobile'        => 'required|min:8|unique:users',
            'password'      => 'required|min:6',
        ], [], [
            'name'          => trans('admin.Name'),
            'email'         => trans('admin.Email'),
            'mobile'        => trans('admin.Mobile'),
            'password'      => trans('admin.Password'),
        ]);

        $user = new User();
        $user->user_type = "admin";
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->save();

        foreach($request->roles as $role){
            $data = Role::find($role);
            $user->attachRole($data);
        }

        userLogs([
            'model'=>'\App\Models\User' ,
            'model_id'=>$user->id ,
            'description_ar'=>'اضافة مشرف جديد',
            'description_en'=>'Add New Admin',
            'status'=>'create'
        ]);
        
        return redirect(aurl('admins'))->with('success','operation success');
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
        $admin = User::find($id);
        $roles = Role::get();
        $rolesId = RoleUser::where('user_id', $id)->get()->pluck('role_id');
        return view('admin.admins.edit',[
            'title' => $admin->name,
            'roles' => $roles,
            'admin' => $admin,
            'rolesId' => $rolesId,
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
            'mobile'        => 'required|min:8|unique:users,id,'.$id,
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
            $user->password = Hash::make($request->password);
        }
        $user->save();

        RoleUser::where('user_id', $user->id)->delete();

        foreach($request->roles as $role){
            $data = Role::find($role);
            $user->attachRole($data);
        }

        userLogs([
            'model'=>'\App\Models\User' ,
            'model_id'=>$user->id ,
            'description_ar'=>'تعديل بيانات المشرف',
            'description_en'=>'Update Admin Data',
            'status'=>'update'
        ]);
        return redirect(aurl('admins'))->with('success','operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->admin_id);
        if($user){
            $user->delete();
        }
        userLogs([
            'model'=>'\App\Models\User' ,
            'model_id'=>$request->admin_id ,
            'description_ar'=>'مسح المشرف',
            'description_en'=>'Delete Admin',
            'status'=>'delete'
        ]);
        return back()->with('success','operation success');
    }

    public function force_delete(Request $request)
    {
        $user = User::withTrashed()->find($request->admin_id);
        if ($user) {
            $user->forceDelete();
        }
        userLogs([
            'model' => '\App\Models\User',
            'model_id' => $request->admin_id,
            'description_ar' => 'حذف نهائى للمشرف',
            'description_en' => 'Force Delete Admin',
            'status' => 'delete'
        ]);
        return back()->with('success', 'operation success');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
        }
        userLogs([
            'model' => '\App\Models\User',
            'model_id' => $id,
            'description_ar' => 'استعادة المشرف',
            'description_en' => 'Restore Admin',
            'status' => 'update'
        ]);
        return back()->with('success', 'operation success');
    }
}
