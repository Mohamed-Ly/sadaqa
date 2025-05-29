<?php

namespace App\Http\Controllers\admin\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    /**
 * Display a listing of the resource.
 */
public function index()
{
    $information = User::findorfail(Auth()->user()->id);
    return view('dashboard.Profile.profile',compact('information'));
}

/**
 * Show the form for creating a new resource.
 */
// public function create()
// {
//     $informations = User::where('rools',0)->get();
//     return view('dashboard.Profile.profile',compact('informations'));
// }

/**
 * Store a newly created resource in storage.
 */
// public function store(Request $request)
// {
//     try {

//         $info = new User();
        
//           $info->name = $request->name;
//           $info->email = $request->email;
//           $info->password = Hash::make($request->password);
//           $info->rools = '0';
//           $info->save();
//         toastr()->success('تم التعديل بنجاح');
//         return redirect()->route('Profile.create');
//     }
//     catch
//     (\Exception $e) {
//         return redirect()->back()->withErrors(['error' => $e->getMessage()]);
//     }
// }

/**
 * Display the specified resource.
 */
public function show(string $id)
{

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
    try {

        if($request->password) {
            if($request->password === $request->confirm_password) {
            $update_info = User::findorfail($id);
            $update_info->update([
              $update_info->name = $request->Name_ar,
              $update_info->password = Hash::make($request->password),
            ]);
            }else{
                toastr()->error('عذرا كلمة السر غير متطابقة');
                return to_route('Admin_Profile.index');
            }
        }else{
            $update_info = User::findorfail($id);
            $update_info->update([
              $update_info->name = $request->Name_ar,
            ]);
        }

        toastr()->success('تم التعديل بنجاح');
        return redirect()->route('Admin_Profile.index');
    }
    catch
    (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}

/**
 * Remove the specified resource from storage.
 */

    // public function destroy(Request $request)
    // {
    //     $User = User::findOrFail($request->id)->delete();
    //         toastr()->error(trans('messages.Delete'));
    //         return redirect()->route('Profile.create');
    // }

}

