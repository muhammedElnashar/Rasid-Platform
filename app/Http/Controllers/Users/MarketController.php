<?php

namespace App\Http\Controllers\Users;

use App\Enum\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\RedemptionRequest;
use App\Models\StoreItem;
use App\Services\RedemptionRequestServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function marketItem()
    {
        $marketItems = StoreItem::with(['role','level'])->where('school_id',\Auth::user()->school->id)->paginate(2);

        return view('users.market',compact('marketItems'));
    }

    public function exchange(Request $request, RedemptionRequestServices $marketServices)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:store_items,id',
        ]);

        $result = $marketServices->exchangeItem($data['item_id']);

        if (!$result['success']) {
            return back()->withErrors(['error' => $result['message']]);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function userAward()
    {
        $awards = RedemptionRequest::with('item')->where('user_id',Auth::id())->get();
        return view('users.user-awards',compact('awards'));
    }
}

