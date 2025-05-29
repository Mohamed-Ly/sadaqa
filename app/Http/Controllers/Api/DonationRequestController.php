<?php

namespace App\Http\Controllers\Api;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Models\DonationRequest;
use App\Http\Controllers\Controller;

class DonationRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'message' => 'nullable|string'
        ]);

        $donation = Donation::find($request->donation_id);

        if ($donation->user_id == auth()->id()) {
            return response()->json(['message' => 'لا يمكنك طلب تبرعك الخاص'], 403);
        }
        if (DonationRequest::where('donation_id',$request->donation_id)->where('user_id',auth()->id())->exists()) {
            return response()->json(['message' => 'لايمكنك طلب نفس الصدقة مرتين'], 403);
        }

        $donationRequest = DonationRequest::create([
            'donation_id' => $request->donation_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'status' => 'pending'
        ]);


        $count_requests = DonationRequest::where('donation_id',$request->donation_id)->count();
        $Number_beneficiaries = $donation->Number_beneficiaries;

        if($count_requests == $Number_beneficiaries) {
            $donation = Donation::find($request->donation_id)->update(['status' => 'donated']);
        }

        return response()->json($donationRequest, 201);
    }

    public function update(Request $request, DonationRequest $donationRequest)
    {
        if ($donationRequest->donation->user_id != auth()->id()) {
            return response()->json(['message' => 'غير مصرح به'], 403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $donationRequest->update(['status' => $request->status]);

        if ($request->status == 'accepted') {
            $donationRequest->donation()->update(['status' => 'reserved']);
        }

        return response()->json($donationRequest);
    }

    public function MyRequest () {
        $get_user_id = DonationRequest::whereIn('user_id',[Auth()->user()->id])->pluck('donation_id');
        $Requests = Donation::with(['requests'])
            ->WhereIn('id',$get_user_id)
            ->get();
        return response()->json($Requests);
    }
}
