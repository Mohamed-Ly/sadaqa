<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Donation;

class DonationPendingAdminReview extends Notification
{
    use Queueable;

    public $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable)
    {
        // إرسال عبر قناتين: قاعدة البيانات والبريد
        return ['database', 'mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎗️ تبرع جديد يحتاج للمراجعة - ' . $this->donation->title)
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('تم إضافة تبرع جديد بواسطة: ' . $this->donation->user->name)
            ->action('مراجعة التبرع', url('/Admin_Donation' ))
            ->line('شكراً لاستخدامك نظام صدقة');
    }

    public function toArray($notifiable)
    {
        return [
            'donation_id' => $this->donation->id,
            'title' => 'تبرع جديد: ' . $this->donation->title,
            'message' => 'يحتاج للمراجعة قبل النشر',
            'type' => 'donation_pending',
            'url' => '/admin/donations/' . $this->donation->id,
            'icon' => 'fas fa-gift',
            'created_at' => now()->toDateTimeString()
        ];
    }
}
