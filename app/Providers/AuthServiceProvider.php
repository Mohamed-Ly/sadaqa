<?php

namespace App\Providers;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // لا تستدعي parent::boot() هنا لأنه غير موجود في الأصل
        
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $email = $notifiable->getEmailForPasswordReset();
            return (new ResetPasswordNotification($token, $email))->toMail($notifiable);
        });
    }
}