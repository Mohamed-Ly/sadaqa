<?php

namespace App\Http\Controllers\admin\RolesAndPermissions;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use  App\Http\Traits\CheckPermissions;
use App\Http\Requests\RolesStoreRequest;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsController extends Controller
{
        use CheckPermissions;
    /**
     * Display a listing of the resource.
     */ 
    public function index()
    {
        $this->CheckPermissions('عرض الأدوار والصلاحيات');
            $roles = Role::all();
            $permissions = Permission::all(); 
            return view('dashboard.RolesAndPermissions.roles_and_permissions', [
                'roles' => $roles,
                'permissions' => $permissions
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
    public function store(RolesStoreRequest $request)
    {
        $this->CheckPermissions('إضافة الأدوار والصلاحيات');
        $role = Role::create([
            'name' => $request->role,
            'guard_name' => 'web',
        ])->givepermissionTo($request->permission);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        toastr()->success('تمت الإضافة بنجاح');
        return redirect()->back();
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
        $this->CheckPermissions('تعديل الأدوار والصلاحيات');
        $role = Role::findorfail($request->id);
        $user = User::where('roole',$role->name)->update(['roole' => $request->role]);
        $role->revokePermissionTo($role->permission);
        $role->givepermissionTo($request->permission);
        $role->update([
            'name' => $request->role,
        ]);
        $role = $role->refresh();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        toastr()->success('تم تحديث البيانات بنجاح');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->CheckPermissions('حذف الأدوار والصلاحيات');
        $role = Role::findorfail($request->id);
        $permission = $role->permission;
        $role->revokePermissionTo($permission);
        $role->delete();
        toastr()->success('تم حذف الدور وصلاحياتة بنجاح');
        return redirect()->back();
    }
}
