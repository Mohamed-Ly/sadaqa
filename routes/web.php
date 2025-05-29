<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



    Route::get('/', function () {
        return view('welcome');
    });



    Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
        

        
    });

    Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () {
        
        Route::get('/dashboard', function () {
            $categories = [
                'طعام' => App\Models\Donation::where('category', 'طعام')->count(),
                'ملابس' => App\Models\Donation::where('category', 'ملابس')->count(),
                'أثاث' => App\Models\Donation::where('category', 'أثاث')->count(),
                'أجهزة' => App\Models\Donation::where('category', 'أجهزة')->count(),
                'أخرى' => App\Models\Donation::whereNotIn('category', ['طعام', 'ملابس', 'أثاث', 'أجهزة'])->count()
            ];
            return view('dashboard.dashboard',compact('categories'));
        })->middleware(['verified'])->name('dashboard');

        Route::resource('Admin_Donation', App\Http\Controllers\admin\Donation\DonationController::class);
        Route::get('Approved_Donation/{id}', [App\Http\Controllers\admin\Donation\DonationController::class,'Approved'])->name('Approved_Donation');
        Route::get('Rejected_Donation/{id}', [App\Http\Controllers\admin\Donation\DonationController::class,'Rejected'])->name('Rejected_Donation');
        Route::get('/donations/{donation}/images', [App\Http\Controllers\admin\Donation\DonationController::class, 'getImages'])->name('getImages');
        Route::resource('Admin_Users', App\Http\Controllers\admin\Users\UsersController::class);
        Route::resource('Admin_Employees', App\Http\Controllers\admin\Employees\EmployeesController::class);
        Route::resource('Admin_Profile', App\Http\Controllers\admin\Profile\ProfileController::class);
        Route::resource('Admin_RoleAndPerimissions', App\Http\Controllers\admin\RolesAndPermissions\RolesAndPermissionsController::class);

        
    });

require __DIR__.'/auth.php';
