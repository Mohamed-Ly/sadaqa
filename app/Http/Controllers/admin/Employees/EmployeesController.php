<?php

namespace App\Http\Controllers\admin\Employees;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use  App\Http\Traits\CheckPermissions;

class EmployeesController extends Controller
{
            use CheckPermissions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->CheckPermissions('عرض الموظفين');
        $users = User::where('roole','!=','مستخدم')->get();
        $roles = Role::all();
        return  view('dashboard.Employees.employees',compact('users','roles'));
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
    public function store(EmployeeRequest $request)
    {
        try {
            $this->CheckPermissions('إضافة الموظفين');
            $check = User::where('email', $request->email)->first();
            if(!$check) {
                if($request->password == $request->confirm_password) {
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'roole' => $request->roole,
                    ]);
                    $user->assignRole($request->roole);
                    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
                    toastr()->success('تم إضافة المستخدم بنجاح');
                    return to_route('Admin_Employees.index');
                }else{
                    toastr()->error('كلمة السر ليست متطابقة');
                    return back();
                }
            }else{
                toastr()->error('البريد الإلكتروني  موجود بالفعل');
                return back();
            }

            

            }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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
    public function update(EmployeeRequest $request, string $id)
    {
        try {
            $this->CheckPermissions('تعديل الموظفين');
            
            // الحصول على المستخدم أولاً
            $user = User::findOrFail($request->id);
            
            // تحديث بيانات المستخدم
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'roole' => $request->roole,
            ]);
            
            // تعيين الدور الجديد (استخدم syncRoles بدلاً من assignRole لتجنب تكرار الأدوار)
            $user->syncRoles($request->roole);
            
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            toastr()->success('تم تحديث البيانات بنجاح');
            return to_route('Admin_Employees.index');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $this->CheckPermissions('حذف الموظفين');
            User::findorfail($request->id)->delete();
            toastr()->success('تم حذف المستخدم بنجاح');
            return to_route('Admin_Employees.index');

       }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
