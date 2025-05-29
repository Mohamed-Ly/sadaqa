<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // التسجيل برقم الهاتف
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'phone' => 'required|string|unique:users|regex:/^\+?[0-9]{8,15}$/',
            'password' => 'required|string|min:6|max:20',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم 255 حرفًا.',
            'name.min' => 'يجب أن يحتوي الاسم على الأقل على 3 أحرف.',
            
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.unique' => 'رقم الهاتف مسجل بالفعل.',
            'phone.regex' => 'رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.',
            
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل على 6 أحرف.',
            'password.max' => 'يجب ألا تتجاوز كلمة المرور 20 حرفًا.',
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'phone' => '218' . substr($request->phone,1),
            'password' => Hash::make($request->password),
            'roole' => 'مستخدم',
            'verification_code' => rand(100000, 999999),
            'verification_code_expires_at' => Carbon::now()->addMinutes(15)
        ]);


        // إرسال OTP
        $this->sendSms($user->phone, $user->verification_code);

        return response()->json([
            'message' => 'تم إنشاء الحساب بنجاح. يرجى التحقق من رقم الهاتف باستخدام الكود المرسل إليك.',
            'phone' => $user->phone
        ], 201);
    }

    // تسجيل الدخول برقم الهاتف
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+?[0-9]{8,15}$/',
            'password' => 'required|string|min:6',
        ], [
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.regex' => 'رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.',
            
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل على 6 أحرف.',
        ]);

        $user = User::where('phone', '218' . substr($request->phone,1))->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => 'بيانات الاعتماد غير صحيحة. يرجى التحقق من رقم الهاتف وكلمة المرور.',
            ]);
        }

        if (!$user->phone_verified_at) {
        $user = User::where('phone', $request->phone)->update(['verification_code' => rand(100000, 999999)]);

        // إرسال OTP
        $this->sendSms($user->phone, $user->verification_code);
        
            return response()->json([
                'message' => 'لم يتم التحقق من رقم الهاتف بعد. يرجى التحقق أولاً.',
                'needs_verification' => true,
                'verification_method' => 'otp',
                'resend_available' => true
            ], 403);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
            'message' => 'تم تسجيل الدخول بنجاح.'
        ]);
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        $request->validate([], [], [
            'currentAccessToken' => 'توكن المصادقة'
        ]);

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح.']);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+?[0-9]{8,15}$/'
        ], [
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.regex' => 'رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.',
        ]);

        $throttleKey = 'send-otp:' . $request->phone;
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'لقد تجاوزت الحد المسموح من الطلبات.',
                'retry_after' => $seconds,
                'retry_after_minutes' => ceil($seconds / 60)
            ], 429);
        }
        RateLimiter::hit($throttleKey, 300); // 5 دقائق

        $user = User::updateOrCreate(
            ['phone' => $request->phone],
            [
                'verification_code' => rand(1000, 9999),
                'verification_code_expires_at' => Carbon::now()->addMinutes(15)
            ]
        );

        $this->sendSms($user->phone, $user->verification_code);

        return response()->json([
            'message' => 'تم إرسال كود التحقق بنجاح إلى رقم الهاتف المحدد.',
            'expires_in' => 15, // دقائق
            'resend_available' => false,
            'resend_after' => 60 // ثانية
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+?[0-9]{8,15}$/',
            'code' => 'required|string|digits:6'
        ], [
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.regex' => 'رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.',
            
            'code.required' => 'حقل كود التحقق مطلوب.',
            'code.string' => 'يجب أن يكون كود التحقق نصًا.',
            'code.digits' => 'يجب أن يتكون كود التحقق من 4 أرقام.',
        ]);

        $throttleKey = 'verify-otp:' . $request->phone;
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'لقد تجاوزت الحد المسموح من المحاولات. يرجى المحاولة لاحقًا.',
                'retry_after' => $seconds,
                'retry_after_minutes' => ceil($seconds / 60)
            ], 429);
        }
        RateLimiter::hit($throttleKey, 600); // 10 دقائق

        $user = User::where('phone', $request->phone)
                ->where('verification_code', $request->code)
                ->where('verification_code_expires_at', '>', Carbon::now())
                ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'code' => 'كود التحقق غير صحيح أو منتهي الصلاحية. يرجى المحاولة مرة أخرى.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $user->update([
            'phone_verified_at' => Carbon::now(),
            'verification_code' => null,
            'verification_code_expires_at' => null
        ]);

        return response()->json([
            'message' => 'تم التحقق من رقم الهاتف بنجاح.',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'verified_at' => $user->phone_verified_at
        ]);
    }

    // طلب إعادة تعيين كلمة المرور
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+?[0-9]{8,15}$/'
        ], [
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.regex' => 'رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.',
        ]);

        $throttleKey = 'forgot-password:' . $request->phone;
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'لقد تجاوزت الحد المسموح من الطلبات. يرجى المحاولة لاحقًا.',
                'retry_after' => $seconds,
                'retry_after_minutes' => ceil($seconds / 60)
            ], 429);
        }
        RateLimiter::hit($throttleKey, 900); // 15 دقيقة

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'message' => 'لا يوجد حساب مسجل بهذا الرقم. يرجى التحقق وإعادة المحاولة.'
            ], 404);
        }

        $user->update([
            'reset_password_code' => rand(1000, 9999),
            'reset_password_code_expires_at' => Carbon::now()->addMinutes(15)
        ]);

        $this->sendSms($user->phone, 
            "كود إعادة تعيين كلمة المرور: {$user->reset_password_code} - صالح لمدة 15 دقيقة"
        );

        return response()->json([
            'message' => 'تم إرسال كود التحقق لإعادة تعيين كلمة المرور إلى رقم الهاتف المسجل.',
            'expires_in' => 5 // دقائق
        ]);
    }

    // التحقق من كود إعادة التعيين
    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+?[0-9]{8,15}$/',
            'code' => 'required|string|digits:4'
        ], [
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصًا.',
            'phone.regex' => 'رقم الهاتف غير صالح. يرجى إدخال رقم هاتف صحيح.',
            
            'code.required' => 'حقل كود التحقق مطلوب.',
            'code.string' => 'يجب أن يكون كود التحقق نصًا.',
            'code.digits' => 'يجب أن يتكون كود التحقق من 4 أرقام.',
        ]);

        $throttleKey = 'verify-reset-code:'.$request->phone;
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'لقد تجاوزت الحد المسموح من المحاولات. يرجى المحاولة لاحقًا.',
                'retry_after' => $seconds,
                'retry_after_minutes' => ceil($seconds / 60)
            ], 429);
        }
        RateLimiter::hit($throttleKey, 300);

        $user = User::where('phone', $request->phone)
               ->where('reset_password_code', $request->code)
               ->where('reset_password_code_expires_at', '>', Carbon::now())
               ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'code' => 'كود التحقق غير صحيح أو منتهي الصلاحية. يرجى التحقق وإعادة المحاولة.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $token = $user->createToken('password_reset_token', ['reset-password'])
                     ->plainTextToken;

        return response()->json([
            'message' => 'تم التحقق من الكود بنجاح. يمكنك الآن تعيين كلمة مرور جديدة.',
            'reset_token' => $token,
            'remaining_attempts' => RateLimiter::remaining($throttleKey, 3)
        ]);
    }

    // تعيين كلمة مرور جديدة
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|max:20|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
        ], [
            'password.required' => 'حقل كلمة المرور الجديدة مطلوب.',
            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل على 6 أحرف.',
            'password.max' => 'يجب ألا تتجاوز كلمة المرور 20 حرفًا.',
            'password.regex' => 'يجب أن تحتوي كلمة المرور على حروف كبيرة وصغيرة وأرقام.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        $user = $request->user();
        
        if (!$user->tokenCan('reset-password')) {
            return response()->json([
                'message' => 'رمز إعادة التعيين غير صالح أو منتهي الصلاحية.'
            ], 403);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_password_code' => null,
            'reset_password_code_expires_at' => null
        ]);

        $user->tokens()->delete();

        return response()->json([
            'message' => 'تم تحديث كلمة المرور بنجاح. يمكنك الآن تسجيل الدخول باستخدام كلمة المرور الجديدة.'
        ]);
    }

    protected function sendSms($phone, $code)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://isend.com.ly/api/http/sms/send', [
                'api_token' => env('ISEND_API_TOKEN', '411|KG7CV5wNZUgjL1BRPZ5B5qDJOLoVpavKKbBaBPHEd883bd55'),
                'recipient' => $phone,
                'sender_id' => env('ISEND_SENDER_ID', 'iSend'),
                'type' => 'plain',
                'message' => "كود التحقق الخاص بك: $code - لا تشارك هذا الكود مع أي شخص."
            ]);

            if (!$response->successful()) {
                \Log::error('Failed to send SMS via iSend: ' . $response->body());
                throw new \Exception('Failed to send SMS: ' . $response->body());
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('iSend SMS Error: ' . $e->getMessage());
            throw $e;
        }
    }
}