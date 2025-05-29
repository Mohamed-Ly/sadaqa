<?php

namespace App\Http\Controllers\admin\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use  App\Http\Traits\CheckPermissions;

class UsersController extends Controller
{
            use CheckPermissions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->CheckPermissions('عرض المستخدمين');
        $users = User::where('roole','مستخدم')->where('status',1)->get();
        // $roles = Role::all();
        return  view('dashboard.Users.users',compact('users'));
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
    public function store(UserRequest $request)
    {
        try {
            $this->CheckPermissions('إضافة مستخدمين');
            $check = User::where('phone', $request->phone)->first();
            if(!$check) {
                if($request->password == $request->confirm_password) {
                    $user = User::create([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'password' => Hash::make($request->password),
                        'roole' => 'مستخدم',
                    ]);
                    $user->assignRole($request->roole);
                    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
                    toastr()->success('تم إضافة المستخدم بنجاح');
                    return to_route('Admin_Users.index');
                }else{
                    toastr()->error('كلمة السر ليست متطابقة');
                    return back();
                }
            }else{
                toastr()->error('رثم الهاتف موجود بالفعل');
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
    public function update(UserRequest $request, string $id)
    {
        try {
            $this->CheckPermissions('تعديل المستخدمين');
            
            // الحصول على المستخدم أولاً
            $user = User::findOrFail($request->id);
            
            // تحديث بيانات المستخدم
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'roole' => 'مستخدم',
            ]);
            
            // تعيين الدور الجديد (استخدم syncRoles بدلاً من assignRole لتجنب تكرار الأدوار)
            $user->syncRoles($request->roole);
            
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            toastr()->success('تم تحديث البيانات بنجاح');
            return to_route('Admin_Users.index');

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
            $this->CheckPermissions('حذف المستخدمين');
            User::findorfail($request->id)->delete();
            toastr()->success('تم حذف المستخدم بنجاح');
            return to_route('Admin_Users.index');

       }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
