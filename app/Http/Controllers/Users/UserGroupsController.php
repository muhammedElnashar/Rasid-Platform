<?php

namespace App\Http\Controllers\Users;

use App\Enum\DeductionTypeEnum;
use App\Enum\StatusCardEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RechargeRequest;
use App\Models\BehaviorLog;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\RedemptionRequest;
use App\Services\RechargeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserGroupsController extends Controller
{
    public function userGroups()
    {
        $user=Auth::user();
        $groups = GroupUser::with(['user','group'])->where('user_id',$user->id)->get();
        return view('users.groups',compact('groups'));
    }

    public function userGroupProfile(Group $group)
    {
        $approvedIssues = $this->groupApprovedIssues($group);
        $unsettledIssues = $this->groupUnsettledIssue($group);
        $deductionCards = $this->deductionCards($group);
        $currentLevel = $group->currentLevel;
        $currentLayer = $group->currentLayer;
        $categories = \App\Models\Category::with(['layers.levels' => function ($q) {
            $q->orderBy('points_required');
        }])->orderBy('id')->get();          $badges = $group->badges;
        $insignias = $group->insignias;
        $groups = Group::select('id', 'name')
            ->where('school_id', auth()->user()->school_id)->where('id','!=',$group->id)
            ->get();
        $logs = $this->groupLogs($group);
        $transfers = $this->transfers($group);
        $groupCards = $this->groupCard($group);
        $awards = $this->groupAward($group);
        return view('users.group-profile',
            compact('group', 'approvedIssues','unsettledIssues','deductionCards','awards',
                'currentLayer','currentLevel','categories','badges','insignias','logs','groups','transfers','groupCards'));
    }

    public function updateGroupProfile(Request $request,Group $group)
    {
        if ($group->leader_id!= Auth::id()){
            abort(403,'غير مصرح لك ');
        }
        $data = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($group->image && Storage::disk('images')->exists($group->image)) {
                Storage::disk('images')->delete($group->image);
            }
            $data['image'] = $request->file('image')->store('groups', 'images');
        }
        $group->update($data);
        return back()->with('success', 'تم تحديث البيانات بنجاح ✅');

    }
    private function groupUnsettledIssue(Group $group)
    {
        $unsettledIssues = $group->cardIssues()
            ->with(['issuedTo', 'cardItem.category.card', 'issuer'])
            ->where('status', StatusCardEnum::Approved)
            ->where('deduction_type',DeductionTypeEnum::Deferred)
            ->whereNull('applied_at')
            ->get();
        return $unsettledIssues;
    }

    private function groupApprovedIssues(Group $group)
    {
        $approvedIssues = $group->cardIssues()
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
    private function deductionCards(Group $group)
    {
        $deductionCards = $group->deductionCards()->latest()->get();
        return $deductionCards;
    }


    private function groupLogs(Group $group)
    {
        $logs = BehaviorLog::with(['issuedBy', 'cardItem'])
            ->where('issued_to_type', get_class($group))
            ->where('issued_to_id', $group->id)
            ->latest()
            ->get();

        return $logs;
    }
    private function transfers(Group $group)
    {
        return  $group->allTransfers()->get();
    }
    private function groupCard(Group $group)
    {
        $userCards= $group->rechargeCards()->get();
        return $userCards;

    }
    private function groupAward(Group $group)
    {
        $awards = RedemptionRequest::with('item')->where('issued_to_id',$group->id)->get();
        return $awards;
    }
    public function recharge(RechargeRequest $request, RechargeService $rechargeService,Group $group)
    {
        if (!$group->active){
            return back()->with('error','المجموعه مقيده الرجاء التواصل مع الإدارة لإعادة التفعيل');
        }
        if ($group->leader_id != Auth::id()){
            return back()->with('error','القائد فقط هوا من له هذة الصلاحية');
        }
        $data = $request->validated();
        $result = $rechargeService->recharge($group, $data['code'], $data['settlement_code']);
        if (!$result['status']) {
            return back()->withErrors(['error' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }

}
