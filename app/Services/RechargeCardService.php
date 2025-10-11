<?php

namespace App\Services;

use App\Models\RechargeCard;
use App\Models\CardItem;
use App\Models\RechargeCardUser;
use Illuminate\Support\Facades\Auth;

class RechargeCardService
{
    public function create(array $data): RechargeCard
    {
        $cardItem = CardItem::with('category.card')->findOrFail($data['card_item_id']);
        $school = Auth::user()->school;
        $data['points'] = $cardItem->points;
        return $school->rechargeCards()->create($data);
    }

    public function update(array $data, RechargeCard $rechargeCard): RechargeCard
    {
        $cardItem = CardItem::with('category.card')->findOrFail($data['card_item_id']);
        $data['points'] = $cardItem->points;
        $rechargeCard->update($data);
        return $rechargeCard;
    }

    public function assign(array $data)
    {
        $code = RechargeCardUser::generateUniqueCode();
        $userCard = RechargeCardUser::create([
            'issued_to_type' => $data['issued_to_type'],
            'issued_to_id' => $data['issued_to_id'],
            'code' => $code,
            'card_id' => $data['card_id'],
            'max_uses' => $data['max_uses'] ?? 1,
            'created_by' => auth()->id(),
        ]);
        return $userCard;

    }

}
