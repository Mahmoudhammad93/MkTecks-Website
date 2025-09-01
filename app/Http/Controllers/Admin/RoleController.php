<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\Table;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index', [
            'title' => trans('admin.All Roles'),
            'roles' => Role::withCount('admins')->paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tables = Table::with('permissions')->get();

        return view('admin.roles.create', [
            'title' => trans('admin.Add New Role'),
            'tables' => $tables
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
            'name'                  => 'required|string|max:255|unique:roles|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'display_name_ar'       => 'required',
            'display_name_en'       => 'required',
            'description_ar'        => 'nullable',
            'description_en'        => 'nullable',
            "permissions"           => "required|array|min:1",
            "permissions.*"         => "required",
        ], [], [
            'name'                  => trans('admin.Role Name'),
            'display_name_ar'       => trans('admin.Name Ar'),
            'display_name_en'       => trans('admin.Name En'),
            'description_ar'        => trans('admin.Description Ar'),
            'description_en'        => trans('admin.Description En'),
            'permissions'           => trans('admin.Permissions'),
        ]);

        $role = Role::create([
            'name' => $request->name,
            'display_name_ar' => $request->display_name_ar,
            'display_name_en' => $request->display_name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
        ]);

        foreach ($request->permissions as $permission) {
            $perm = Permission::find($permission);
            $role->attachPermission($perm);
        }

        userLogs([
            'model' => '\App\Models\Role',
            'model_id' => $role->id,
            'description_ar' => 'اضافة تصاريح جديدة',
            'description_en' => 'Add New Permissions',
            'status' => 'create'
        ]);

        return redirect(aurl('roles'))->with('success', 'operation success');
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
        $tables = Table::with('permissions')->get();
        $role = Role::where('id', $id)->first();
        $permissionsId = PermissionRole::where('role_id', $id)->get()->pluck('permission_id');
        $tableIds = Permission::whereIn('id', $permissionsId)->get()->pluck('table_id');
        return view('admin.roles.edit', [
            'title' => $role->display_name,
            'tables' => $tables,
            'role' => $role,
            'permissionsId' => $permissionsId,
            'tableIds' => $tableIds,
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
            'name'                  => 'required|string|max:255|regex:/(^([a-zA-Z]+)(\d+)?$)/u|unique:roles,id,' . $id,
            'display_name_ar'       => 'required',
            'display_name_en'       => 'required',
            'description_ar'        => 'nullable',
            'description_en'        => 'nullable',
            "permissions"           => "required|array|min:1",
            "permissions.*"         => "required",
        ], [], [
            'name'                  => trans('admin.Role Name'),
            'display_name_ar'       => trans('admin.Name Ar'),
            'display_name_en'       => trans('admin.Name En'),
            'description_ar'        => trans('admin.Description Ar'),
            'description_en'        => trans('admin.Description En'),
            'permissions'           => trans('admin.Permissions'),
        ]);

        $role = Role::where('id', $id)->first();
        $role->name = $request->name;
        $role->display_name_ar = $request->display_name_ar;
        $role->display_name_en = $request->display_name_en;
        $role->description_ar = $request->description_ar;
        $role->description_en = $request->description_en;
        $role->save();


        PermissionRole::where('role_id', $id)->delete();
        foreach ($request->permissions as $permission) {
            $perm = Permission::find($permission);
            $role->attachPermission($perm);
        }

        userLogs([
            'model' => '\App\Models\Role',
            'model_id' => $role->id,
            'description_ar' => 'تحديث بيانات التصاريح',
            'description_en' => 'Update Permissions Details',
            'status' => 'update'
        ]);

        return redirect(aurl('roles'))->with('success', 'operation success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $role = Role::where('id', $request->role_id)->first();
        if ($role) {
            $role->delete();
        }

        userLogs([
            'model' => '\App\Models\Role',
            'model_id' => $request->role_id,
            'description_ar' => 'حضف التصريح',
            'description_en' => 'Delete Permissions',
            'status' => 'delete'
        ]);

        return redirect(aurl('roles'))->with('success', 'operation success');
    }
}
