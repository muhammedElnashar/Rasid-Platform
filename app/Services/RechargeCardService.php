<?php

namespace App\Services;

use App\Models\RechargeCard;
use App\Models\CardItem;
use Illuminate\Support\Facades\Auth;

class RechargeCardService
{
    public function create(array $data): RechargeCard
    {
        $cardItem = CardItem::with('category.card')->findOrFail($data['card_item_id']);
        $school = Auth::user()->school;
        $data['code'] = RechargeCard::generateUniqueCode();
        $data['points'] = $cardItem->points;
        return $school->rechargeCards()->create($data);
    }
    public function update(array $data,RechargeCard $rechargeCard): RechargeCard
    {
        $cardItem = CardItem::with('category.card')->findOrFail($data['card_item_id']);
        $data['points'] = $cardItem->points;
        $rechargeCard->update($data);
        return $rechargeCard  ;
    }

}
