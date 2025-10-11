<?php

namespace App\Http\Controllers\Users;

use App\Enum\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\RedemptionRequest;
use App\Models\StoreItem;
use App\Services\RedemptionRequestServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function marketItem()
    {
        $marketItems = StoreItem::with(['role','level'])->where('school_id',\Auth::user()->school->id)->paginate(10);

        return view('users.market',compact('marketItems'));
    }
    public function groupMarketItem(Group $group)
    {
        if ($group->leader_id !== \Illuminate\Support\Facades\Auth::id()){
            abort(403,'غير مصرح لك بالدخول');
        }
        $marketItems = StoreItem::with('level')->where('school_id',\Auth::user()->school->id)->whereNull('target_role')->paginate(10);

        return view('users.group-market',compact('marketItems','group'));
    }


    public function userExchange(Request $request, RedemptionRequestServices $marketServices)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:store_items,id',
        ]);

        $user = Auth::user();
        $result = $marketServices->exchangeItem($data['item_id'], $user);

        if (!$result['success']) {
            return back()->withErrors(['error' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }
    public function groupExchange(Request $request, RedemptionRequestServices $marketServices)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:store_items,id',
            'group_id' => 'required|exists:groups,id',
        ]);
        $group = \App\Models\Group::findOrFail($data['group_id']);
        $result = $marketServices->exchangeItem($data['item_id'], $group);

        if (!$result['success']) {
            return back()->withErrors(['error' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }


    public function userAward()
    {
        $awards = RedemptionRequest::with('item')->where('issued_to_id',Auth::id())->get();
        return view('users.user-awards',compact('awards'));
    }

}

