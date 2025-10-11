<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\RedemptionRequest;
use App\Services\RedemptionRequestServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedemptionRequestController extends Controller
{
    protected $redemptionRequest;
    public function __construct(RedemptionRequestServices $redemptionRequest)
    {
        $this->redemptionRequest = $redemptionRequest ;
    }

    public function requests()
    {
        $this->authorize('viewAny',RedemptionRequest::class);
        $schoolId = Auth::user()->school_id;
        $requests = RedemptionRequest::with(['issuedTo', 'item'])
            ->whereHas('issuedTo', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })
            ->whereHas('item', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })
            ->get();

        return view('school_admin.store-items.requests',compact('requests'));
    }

    public function approvedRequest(RedemptionRequest $request)
    {
        $this->authorize('approve', $request);
        $this->redemptionRequest->approvedRequest($request);
        return redirect()->back()->with('success','تم اعتماد الجائزة');
    }

    public function rejectRequest(RedemptionRequest $request)
    {

        $this->authorize('reject', $request);
        $this->redemptionRequest->rejectRequest($request);
        return redirect()->back()->with('success','تم رفض الجائزة');
    }
}
