<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCardIssueRequest;
use App\Http\Requests\UpdateCardIssueRequest;
use App\Models\CardIssues;
use App\Services\CardIssueService;
use Illuminate\Http\Request;

class CardIssueController extends Controller
{
    protected $cardIssueService;

    public function __construct(CardIssueService $cardIssueService)
    {
        $this->cardIssueService = $cardIssueService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',CardIssues::class);
        $school = auth()->user()->school;
        $users = $school->users()->usersExpectAdmins()->with('role')->get();
        $cards = $school->cards()->with('categories.items')->get();
        $pendingIssues = $school->pendingIssues()->with(['user', 'cardItem.category.card', 'issuer'])->get();
        return view('school_admin.card-issues.pending-issues', compact('pendingIssues','users','cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',CardIssues::class);
        $school = auth()->user()->school;
        $users = $school->users()->usersExpectAdmins()->with('role')->get();
        $cards = $school->cards()->with('categories.items')->get();
        return view('school_admin.card-issues.issue-create', compact('users', 'cards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardIssueRequest $request)
    {
        $this->authorize('create',CardIssues::class);
        $user = auth()->user();
        $data = $request->validated();
        $this->cardIssueService->issueCard($data, $user);
        return redirect()->route('issues.index')
            ->with('success', __('message.created', ['item' => __('message.card_issue')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CardIssues $issue)
    {
        $this->authorize('update', $issue);
        $school = auth()->user()->school;
        $users = $school->users()->usersExpectAdmins()->with('role')->get();
        $cards = $school->cards()->with('categories.items')->get();
        return view('school_admin.card-issues.issue-edit', compact('issue', 'users', 'cards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCardIssueRequest $request, CardIssues $issue)
    {
        $this->authorize('update', $issue);
        $user = auth()->user();
        $data = $request->validated();
        $this->cardIssueService->updateIssueCard($data,$user, $issue);
        return to_route('issues.index')->with('success', __('message.updated', ['item' => __('message.card_issue')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CardIssues $issue)
    {
        $this->authorize('delete', $issue);
        $issue->delete();
        return redirect()->route('issues.index')->with('success', __('message.deleted', ['item' => __('message.card_issue')]));
    }

    public function approved(Request $request,CardIssues $issue)
    {
        $this->authorize('approve', $issue);
        $this->cardIssueService->approve($issue);
        return to_route('issues.index')->with('success',__('message.approved', ['item' => __('message.issue')]));
    }

    public function approvedIssues()
    {
        $this->authorize('viewAny',CardIssues::class);
        $school = auth()->user()->school;
        $approvedIssues = $school->approvedIssues()->with(['user', 'cardItem.category.card', 'issuer'])->get();
        return view('school_admin.card-issues.approved-issues',compact('approvedIssues'));
    }

    public function rejected(Request $request,CardIssues $issue)
    {
        $this->authorize('reject', $issue);
        $this->cardIssueService->reject($issue);
        return to_route('issues.index')->with('success',__('message.reject', ['item' => __('message.issue')]));


    }
    public function rejectedIssues()
    {
        $this->authorize('viewAny',CardIssues::class);
        $school = auth()->user()->school;
        $rejectedIssues = $school->rejectedIssues()->with(['user', 'cardItem.category.card', 'issuer'])->get();
        return view('school_admin.card-issues.rejected-issue',compact('rejectedIssues'));
    }
}
