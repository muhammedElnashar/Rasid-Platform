<?php

namespace App\Http\Controllers\Users;

use App\Enum\DeductionTypeEnum;
use App\Enum\StatusCardEnum;
use App\Http\Controllers\Controller;
use App\Models\BehaviorLog;
use App\Models\CardIssues;
use App\Models\Group;
use App\Models\RedemptionRequest;
use App\Models\StudentGuardian;
use App\Models\User;
use App\Services\CardIssueService;
use App\Services\RechargeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            ->with(['issuedTo', 'cardItem.category.card', 'issuer'])
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
            ->with(['issuedTo', 'cardItem.category.card', 'issuer'])
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
        $subjectClasses= $user->subjectsForTeacher();
        $parents= $user->guardians()->get();
        $currentLevel = $user->currentLevel;
        $currentLayer = $user->currentLayer;
        $levelsInLayer = $currentLayer?->levels()->orderBy('points_required')->get();
        $insignias = $user->insignias;
        $badges = $user->badges;
        $studentSubjects = $user->studentSubjects()->with('subject')->get();
        $studentClass = $user->studentClass()->with('class')->get();



        return view('school_admin.users.profile',compact(
            'user','subjectClasses','parents','badges'
            ,'currentLevel','currentLayer','levelsInLayer','insignias','studentSubjects','studentClass'
        ));
    }

    public function settle(CardIssues $issue, Request $request)
    {
        $user = auth()->user();

        if ($issue->issued_to_type === \App\Models\User::class) {
            if ($issue->issuedTo->id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        }

        if ($issue->issued_to_type === \App\Models\Group::class) {
            if ($issue->issuedTo->leader_id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        }
        try {
            $amount = $request->input('amount');
            $this->cardIssueService->settle($issue, $amount);

            return redirect()->back()->with(
                'success',
                __('message.paid', ['item' => __('message.card')])
            );

        } catch (\DomainException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'حدث خطأ غير متوقع']);
        }
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
        $user = Auth::user();

        $logs = BehaviorLog::with(['issuedBy', 'cardItem'])
            ->where('issued_to_type', get_class($user))
            ->where('issued_to_id', $user->id)
            ->latest()
            ->get();

        return view('users.user-logs', compact('logs'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('images')->exists($user->image)) {
                Storage::disk('images')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('avatars', 'images');
        }
        $user->update(array_filter($data));

        return back()->with('success', 'تم تحديث البيانات بنجاح ✅');
    }

    public function children()
    {
        $user = Auth::user();
        if ($user->role->name !== 'parent'){
            abort(403,'غير مصرح لك ');
        }
        $children = StudentGuardian::with('student')->where('guardian_id',$user->id)->get();
        return view('users.children',compact('children'));
    }

    public function childrenProfile(User $user)
    {
        $parent = Auth::user();
        if (!$parent->isGuardian()){
            abort(403,'غير مصرح لك ');
        }

        $currentLevel = $user->currentLevel;
        $currentLayer = $user->currentLayer;
        $levelsInLayer = $currentLayer?->levels()->orderBy('points_required')->get();
        $insignias = $user->insignias;
        $badges = $user->badges;
        $studentSubjects = $user->studentSubjects()->with('subject')->get();
        $studentClass = $user->studentClass()->with('class')->get();
        $approvedIssues = $this->childApprovedIssues($user);
        $unsettledIssues = $this->childUnsettledIssue($user);
        $deductionCards = $this->childDeductionCards($user);
        $logs = $this->childLogs($user);
        $transfers = $this->childTransfers($user);
        $childCards = $this->childCard($user);
        $awards = $this->childAward($user);
        return view('users.children-profile',compact('user','currentLevel','currentLayer','insignias'
        ,'badges','levelsInLayer','studentSubjects','studentClass','deductionCards','approvedIssues','unsettledIssues'
        ,'logs','transfers','childCards','awards'));
    }
    private function childUnsettledIssue(User $child)
    {
        $unsettledIssues = $child->cardIssues()
            ->with(['issuedTo', 'cardItem.category.card', 'issuer'])
            ->where('status', StatusCardEnum::Approved)
            ->where('deduction_type',DeductionTypeEnum::Deferred)
            ->whereNull('applied_at')
            ->get();
        return $unsettledIssues;
    }

    private function childApprovedIssues(User $child)
    {
        $approvedIssues = $child->cardIssues()
            ->with(['issuedTo', 'cardItem.category.card', 'issuer'])
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

        return $approvedIssues;
    }
    private function childDeductionCards(User $child)
    {
        $deductionCards = $child->deductionCards()->latest()->get();
        return $deductionCards;
    }
    private function childLogs(User $child)
    {
        $logs = BehaviorLog::with(['issuedBy', 'cardItem'])
            ->where('issued_to_type', get_class($child))
            ->where('issued_to_id', $child->id)
            ->latest()
            ->get();

        return $logs;
    }
    private function childTransfers(User $child)
    {
        return  $child->allTransfers()->get();
    }
    private function childCard(User $child)
    {
        $childCards= $child->rechargeCards()->get();
        return $childCards;

    }
    private function childAward(User $child)
    {
        $awards = RedemptionRequest::with('item')->where('issued_to_id',$child->id)->get();
        return $awards;
    }
}
