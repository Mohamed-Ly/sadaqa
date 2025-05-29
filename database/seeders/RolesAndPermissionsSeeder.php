<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $ArrayOfPermissionName = [
            'عرض الصدقات' ,  'إدارة طلبات الصدقات','عرض صور الصدقات',
            'عرض الأدوار والصلاحيات' , 'إضافة الأدوار والصلاحيات' , 'تعديل الأدوار والصلاحيات' ,  'حذف الأدوار والصلاحيات',
            'عرض المستخدمين' , 'إضافة مستخدمين' , 'تعديل المستخدمين' , 'حذف المستخدمين',
            'عرض الموظفين' , 'إضافة الموظفين' , 'تعديل الموظفين' , 'حذف الموظفين',
        ];

        $permission = collect($ArrayOfPermissionName)->map(function($permission){
            return ['name' => $permission , 'guard_name' => 'web'];
        });

        Permission::insert($permission->toArray());

        $role = Role::create(['name' => 'super_admin'])->givepermissionTo($ArrayOfPermissionName);
    }
}
