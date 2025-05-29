<?php

namespace App\Http\Traits;
use Auth;

trait CheckPermissions
{
    public function CheckPermissions($permissions) 
    {
        
        if (!Auth::user()->can($permissions)) { 
            return redirect()->back()->with(['error' => 'عذرا ليس لديك الصلاحيات الكافية للمرور'])->send();
        }
    }
}