<?php

namespace App\Http\Controllers;

use App\Enum\DeductionTypeEnum;
use App\Enum\StatusCardEnum;
use App\Models\CardIssues;
use App\Services\CardIssueService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $cardIssueService;

    public function __construct(CardIssueService $cardIssueService)
    {
        $this->cardIssueService = $cardIssueService;
    }

    public function UserProfile()
    {
        $user=auth()->user();
        $unsettledIssues = $user->cardIssues()
            ->with(['user', 'cardItem.category.card', 'issuer'])
            ->where('status', StatusCardEnum::Approved)
            ->whereNull('applied_at')
            ->get();

        $issues = $user->cardIssues()
            ->with(['user', 'cardItem.category.card', 'issuer'])
            ->where('status', StatusCardEnum::Approved)
            ->whereNotNull('applied_at')
            ->get();
        return view('profile',compact('user','unsettledIssues','issues'));
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

}
