<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCardIssueRequest;
use App\Http\Requests\UpdateCardIssueRequest;
use App\Models\CardIssues;
use App\Models\Role;
use App\Models\User;
use App\Services\CardIssueService;
use App\Services\DeductionCardService;
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
        $pendingIssues = $school->issues()->with(['user', 'cardItem.category.card', 'issuer'])->get();
        return view('school_admin.card-issues.pending-issues', compact('pendingIssues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',CardIssues::class);
        $school = auth()->user()->school;
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $users = User::select('id', 'full_name', 'role_id')
            ->where('school_id', auth()->user()->school_id)
            ->get();
        $cards = $school->cards()->with('categories.items')->get();
        return view('school_admin.card-issues.issue-create', compact('users', 'cards','roles'));
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
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $users = User::select('id', 'full_name', 'role_id')
            ->where('school_id', auth()->user()->school_id)
            ->get();        $cards = $school->cards()->with('categories.items')->get();
        return view('school_admin.card-issues.issue-edit', compact('issue', 'users', 'cards','roles'));
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

    public function approved(Request $request, CardIssues $issue)
    {
        $this->authorize('approve', $issue);
        $this->cardIssueService->approve($issue);
        app(DeductionCardService::class)->applyBestCard($issue->user);
        return to_route('issues.index')
            ->with('success', __('message.approved', ['item' => __('message.issue')]));
    }

/*    public function approvedIssues()
    {
        $this->authorize('viewAny',CardIssues::class);
        $school = auth()->user()->school;
        $approvedIssues = $school->approvedIssues()->with(['user', 'cardItem.category.card', 'issuer'])->get();
        return view('school_admin.card-issues.approved-issues',compact('approvedIssues'));
    }*/

    public function rejected(Request $request,CardIssues $issue)
    {
        $this->authorize('reject', $issue);
        $this->cardIssueService->reject($issue);
        return to_route('issues.index')->with('success',__('message.Rejected', ['item' => __('message.issue')]));


    }

    public function unrestricted(CardIssues $issue)
    {
        $this->authorize('unrestricted', $issue);
        $this->cardIssueService->unrestricted($issue);
        return to_route('issues.index')->with('success','تم فك القيد بنجاح');
    }
}
