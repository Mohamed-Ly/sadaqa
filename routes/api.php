<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
// Route::post('/send-otp', [App\Http\Controllers\Api\AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [App\Http\Controllers\Api\AuthController::class, 'verifyOtp']);
// Route::post('/forgot-password', [App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
// Route::post('/verify-reset-code', [App\Http\Controllers\Api\AuthController::class, 'verifyResetCode']);
// Route::post('/reset-password', [App\Http\Controllers\Api\AuthController::class, 'resetPassword'])
//     ->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);


    Route::apiResource('donations', App\Http\Controllers\Api\DonationController::class)
        ->except(['update', 'destroy']);
    Route::get('my-donation', [App\Http\Controllers\Api\DonationController::class, 'MyDonation']);

    // طلبات التبرع
    Route::post('donation-requests', [App\Http\Controllers\Api\DonationRequestController::class, 'store']);
    Route::put('donation-requests/{donationRequest}', [App\Http\Controllers\Api\DonationRequestController::class, 'update']);
    Route::get('my-request', [App\Http\Controllers\Api\DonationRequestController::class, 'MyRequest']);
});

