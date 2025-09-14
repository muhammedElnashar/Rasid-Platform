<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRechargeCardRequest;
use App\Models\RechargeCard;
use App\Models\RechargeCardUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RechargeCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',RechargeCard::class);
        $school = auth()->user()->school;
        $rechargeCards= $school->rechargeCards()->get();
        return view('school_admin.recharge-cards.index',compact('rechargeCards'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',RechargeCard::class);
        return view('school_admin.recharge-cards.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',RechargeCard::class);
        $data =$request->validate([
            'points'=>'required|integer|min:1',
        ]);
        $school=auth()->user()->school;
        $data['code']=RechargeCard::generateUniqueCode();
        $rechargeCard=$school->rechargeCards()->create($data);
        return redirect()->route('recharge-cards.index')->with('success',__('message.created', ['item' => __('message.recharge_card')]));

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RechargeCard $rechargeCard)
    {
        $this->authorize('update', $rechargeCard);
        $data =$request->validate([
            'points'=>'required|integer|min:1',
        ]);
        $rechargeCard->update($data);
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
        $this->authorize('viewAny', RechargeCard::class);

        $roles = Role::ExpectModeratorAndAdmin()->get();
        $cards = RechargeCard::all();
        $users = User::select('id', 'full_name', 'role_id')
            ->where('school_id', auth()->user()->school_id)
            ->get();

        return view('school_admin.recharge-cards.assign', compact('roles', 'cards', 'users'));
    }


    public function assign(AssignRechargeCardRequest $request)
    {
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
        $assignCards= RechargeCardUser::with(['user','card'])->get();
        return view('school_admin.recharge-cards.assign-list',compact('assignCards'));
    }


}
