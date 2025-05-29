<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Donation extends Model
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'user_id', 'title', 'description',
        'category', 'status', 'city',
        'state', 'approval_status',
        'rejection_reason','Number_beneficiaries','phoen',
        'backup_number'
    ];

    protected $attributes = [
    'approval_status' => 'pending'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(DonationImage::class);
    }

    public function requests()
    {
        return $this->hasMany(DonationRequest::class);
    }
}
