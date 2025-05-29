<?php

namespace App\Http\Controllers\Api;

use App\Models\Donation;
use App\Models\DonationImage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\DonationPendingAdminReview;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    public function index()
    {
        return Donation::with(['user', 'images'])
            ->where('approval_status', 'approved')
            ->where('status', 'available')
            ->latest()
            ->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'Number_beneficiaries' => 'required|numeric|min:1',
            'category' => 'required|in:clothes,furniture,food,electronics,other',
            'city' => 'required|string',
            'state' => 'required|string',
            'phoen' => 'required|digits:10',
            'backup_number' => 'nullable|digits:10',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // إنشاء التبرع بحالة "في انتظار الموافقة"
        $donation = Donation::create([
            'user_id' => 2,
            'title' => $request->title,
            'description' => $request->description,
            'Number_beneficiaries' => $request->Number_beneficiaries,
            'category' => $request->category,
            'city' => $request->city,
            'state' => $request->state,
            'phoen' => $request->phoen,
            'backup_number' => $request->backup_number,
            'status' => 'available',
            'approval_status' => 'pending'
        ]);

        // حفظ الصور
        foreach ($request->file('images') as $image) {
            $path = $image->store('donations', 'public');
            DonationImage::create([
                'donation_id' => $donation->id,
                'image_path' => $path
            ]);
        }

        // إرسال إشعار لجميع الأدمن
        $admins = User::where('roole','!=','مستخدم')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DonationPendingAdminReview($donation));
        }

        return response()->json([
            'message' => 'تم إرسال التبرع بنجاح وهو بانتظار الموافقة من الأدمن',
            'data' => $donation->load('images')
        ], 201);
    }

    public function show(Donation $donation)
    {
        return $donation->load(['user', 'images']);
    }

        public function MyDonation() {
            return Donation::with(['requests.user'])
                ->where('user_id', Auth()->user()->id)
                ->get();
        }
}
