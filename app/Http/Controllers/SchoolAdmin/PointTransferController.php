<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePointTransferRequest;
use App\Models\PointTransfer;
use App\Models\Role;
use App\Models\User;
use App\Services\TransferPointsServices;

class PointTransferController extends Controller
{
    protected $transferService;

    public function __construct(TransferPointsServices $transferService)
    {
        $this->transferService = $transferService;
    }
    public function index()
    {
        $this->authorize('viewAny',PointTransfer::class);
        $schoolId = auth()->user()->school_id;
        $transfers = PointTransfer::forSchool($schoolId)->with(['sender','receiver'])->latest()->get();
        return view('school_admin.point-transfers.index', compact('transfers'));
    }

    public function create ()
    {
        $this->authorize('create',PointTransfer::class);
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $users = User::select('id', 'full_name', 'role_id','username')
            ->where('school_id', auth()->user()->school_id)->where('id', '!=', auth()->id())
            ->get();
        return view('school_admin.point-transfers.create',compact('users','roles'));
    }

    public function store(StorePointTransferRequest $request)
    {
        $this->authorize('create',PointTransfer::class);
        $this->transferService->transferPoint(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('profile')
            ->with('success', __('message.transfer_created'));
    }

    public function approved(PointTransfer $transfer)
    {
        $this->authorize('approve', $transfer);
        $this->transferService->approved($transfer);
        return to_route('transfer.index')->with('success',__('message.Approved', ['item' => __('message.transfer')]));
    }
    public function rejected(PointTransfer $transfer)
    {
        $this->authorize('reject', $transfer);
        $this->transferService->rejected($transfer);
        return to_route('transfer.index')->with('success',__('message.rejected', ['item' => __('message.transfer')]));

    }
}
