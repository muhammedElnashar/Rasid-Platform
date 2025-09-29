<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Enum\CardNameEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRechargeCardRequest;
use App\Http\Requests\StoreRechargeCardRequest;
use App\Models\RechargeCard;
use App\Models\RechargeCardUser;
use App\Models\Role;
use App\Models\User;
use App\Services\RechargeCardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RechargeCardController extends Controller
{
    protected  $rechargeService;

    public function __construct(RechargeCardService $service)
    {
        $this->rechargeService = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',RechargeCard::class);
        $school = auth()->user()->school;
        $rechargeCards= $school->rechargeCards()->with('cardItem.category.card')->get();

        return view('school_admin.recharge-cards.index',compact('rechargeCards'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',RechargeCard::class);
        $school = auth()->user()->school;
        $cards = $school->cards()->where('name',CardNameEnum::Positive_Support)->with('categories.items')->get();
        return view('school_admin.recharge-cards.create',compact('cards'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRechargeCardRequest $request)
    {
        $this->authorize('create', RechargeCard::class);

        $this->rechargeService->create($request->validated());

        return redirect()
            ->route('recharge-cards.index')
            ->with('success', __('message.created', ['item' => __('message.recharge_card')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(RechargeCard $rechargeCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RechargeCard $rechargeCard)
    {
        $this->authorize('update', $rechargeCard);
        $school = auth()->user()->school;
        $cards = $school->cards()->where('name',CardNameEnum::Positive_Support)->with('categories.items')->get();
        return view('school_admin.recharge-cards.edit',compact('cards','rechargeCard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRechargeCardRequest $request, RechargeCard $rechargeCard)
    {
        $this->authorize('update', $rechargeCard);
        $data =$request->validated();
        $this->rechargeService->update($data,$rechargeCard);
        return redirect()->route('recharge-cards.index')->with('success',__('message.updated', ['item' => __('message.recharge_card')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RechargeCard $rechargeCard)
    {
        $this->authorize('delete', $rechargeCard);
        $rechargeCard->delete();
        return redirect()->route('recharge-cards.index')->with('success',__('message.deleted', ['item' => __('message.recharge_card')]));
    }

    public function assignCard()
    {
        $this->authorize('create', RechargeCard::class);
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $cards = RechargeCard::all();
        $users = User::select('id', 'full_name', 'role_id','username')
            ->where('school_id', auth()->user()->school_id)
            ->get();

        return view('school_admin.recharge-cards.assign', compact('roles', 'cards', 'users'));
    }


    public function assign(AssignRechargeCardRequest $request)
    {
        $this->authorize('create', RechargeCard::class);
        $validated = $request->validated();

        if (!empty($validated['user_id'])) {
            $data = collect($validated['user_id'])->map(function ($userId) use ($validated) {
                return [
                    'user_id' => $userId,
                    'card_id' => $validated['card_id'],
                    'max_uses' => $validated['max_uses'] ?? 1,
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            RechargeCardUser::insert($data);
        }

        return to_route('recharge.list')->with('success', __('message.assign_success'));
    }

    public function list()
    {
        $this->authorize('viewAny', RechargeCard::class);
        $schoolId = Auth::user()->school_id;

        $assignCards= RechargeCardUser::with(['user','card'])
            ->whereHas('user', function($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })->get();
        return view('school_admin.recharge-cards.assign-list',compact('assignCards'));
    }

    public function active(RechargeCardUser $rechargeCardUser)
    {
        $this->authorize('activation',$rechargeCardUser);
        $newActive = !$rechargeCardUser->is_active;
        $rechargeCardUser->update(['is_active' => $newActive]);
        return back()->with('success', $rechargeCardUser->is_active ? 'تم التفعيل' : 'تم التعطيل');

    }


}
