<?php

namespace App\Http\Controllers\admin\Donation;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Http\Traits\CheckPermissions;

class DonationController extends Controller
{
    use CheckPermissions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->CheckPermissions('عرض الصدقات');
        $Donations = Donation::where('approval_status','pending')->with('images','user')->orderBy('id','DESC')->get();
        return view('dashboard.Donations.pending',compact('Donations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->CheckPermissions('عرض الصدقات');
        $Donations = Donation::where('approval_status','rejected')->with('images','user')->orderBy('id','DESC')->get();
        return view('dashboard.Donations.rejected',compact('Donations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $this->CheckPermissions('عرض الصدقات');
       $Donations = Donation::where('approval_status','approved')->with('images','user')->orderBy('id','DESC')->get();
        return view('dashboard.Donations.approved',compact('Donations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }

    public function Approved ($id) {
        // موافقة على الصدقة
        $this->CheckPermissions('إدارة طلبات الصدقات');
        Donation::findorfail($id)->update(['approval_status' => 'approved']);
        toastr()->success('تمت الموافقة على الصدقة بنجاح');
        return to_route('Admin_Donation.index');
    }

    public function Rejected ($id) {
       // إلغاء الصدقة
        $this->CheckPermissions('إدارة طلبات الصدقات');
        Donation::findorfail($id)->update(['approval_status' => 'rejected']);
        toastr()->success('تم إلغاء طلب الصدقة بنجاح');
        return to_route('Admin_Donation.index');
    }

    public function getImages($donationId)
    {
        $this->CheckPermissions('عرض صور الصدقات');
        try {
            
            $donation = Donation::with('images')->findOrFail($donationId);
            
            // تحويل المسارات إلى URLs كاملة إذا لزم الأمر
            $images = $donation->images->map(function($image) {
                return [
                    'path' => asset('storage/' . $image->image_path) // تعديل هذا حسب مكان تخزين الصور
                ];
            });

            return response()->json([
                'success' => true,
                'images' => $images
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load images'
            ], 500);
        }
    }
}
