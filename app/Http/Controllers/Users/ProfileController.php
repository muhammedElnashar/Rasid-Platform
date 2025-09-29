<?php

namespace App\Http\Controllers\Users;

use App\Enum\StatusCardEnum;
use App\Http\Controllers\Controller;
use App\Models\BehaviorLog;
use App\Models\CardIssues;
use App\Services\CardIssueService;
use App\Services\RechargeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $cardIssueService;

    public function __construct(CardIssueService $cardIssueService)
    {
        $this->cardIssueService = $cardIssueService;
    }

    public function transfers()
    {
        $transfers = Auth::user()->allTransfers()->get();
        return view('users.all-transfers', compact('transfers'));
    }
    public function unsettledIssue()
    {
        $user=auth()->user();
        $unsettledIssues = $user->cardIssues()
            ->with(['user', 'cardItem.category.card', 'issuer'])
            ->where('status', StatusCardEnum::Approved)
            ->whereNull('applied_at')
            ->get();
        return view('users.deferred-issue',compact('unsettledIssues'));
    }

    public function deductionCards()
    {
        $deductionCards = auth()->user()->deductionCards()->latest()->get();
        return view('users.deduction-cards',compact('deductionCards'));

    }

    public function approvedIssue()
    {
        $user = auth()->user();

        $approvedIssues = $user->cardIssues()
            ->with(['user', 'cardItem.category.card', 'issuer'])
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('status', StatusCardEnum::Approved)
                        ->whereNotNull('applied_at');
                })
                    ->orWhereIn('status', [
                        StatusCardEnum::Pending,
                        StatusCardEnum::Rejected,
                    ]);
            })
            ->get();

        return view('users.approved-issue', compact('approvedIssues'));
    }


    public function UserProfile()
    {

        $user=auth()->user();
        $subjectClasses= $user->subjectsForUser();
        $parents= $user->guardians()->get();
        $currentLevel = $user->currentLevel;
        $currentLayer = $user->currentLayer;
        $levelsInLayer = $currentLayer?->levels()->orderBy('points_required')->get();
        $insignias = $user->insignias;
        $badges = $user->badges;



        return view('school_admin.users.profile',compact(
            'user','subjectClasses','parents'
            ,'currentLevel','currentLayer','levelsInLayer','insignias','badges'
        ));
    }

    public function settle(CardIssues $issue, Request $request)
    {
        if ($issue->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $amount = $request->input('amount');

        $this->cardIssueService->settle($issue, $amount);

        return redirect()->back()->with('success', __('message.paid', ['item' => __('message.card')]));
    }

    public function userCard()
    {
        $userCards= auth()->user()->rechargeCards()->get();
        return view('users.user-recharge-card',compact('userCards'));

    }
    public function rechargePage()
    {
        return view('users.recharge');
    }


    public function recharge(Request $request, RechargeService $rechargeService)
    {
        $data = $request->validate([
            'code' => 'required|string',
            'settlement_code' => 'required|string',
        ]);
        $user = auth()->user();
        $result = $rechargeService->recharge($user, $data['code'], $data['settlement_code']);
        if (!$result['status']) {
            return back()->withErrors(['error' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }

    public function userLogs()
    {
        $logs = BehaviorLog::with(['issuedBy','cardItem'])->where('user_id',Auth::id())->get();
        return view('users.user-logs',compact('logs'));
    }

}
