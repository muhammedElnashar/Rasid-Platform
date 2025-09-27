<?php

namespace App\Enum;

enum CardNameEnum:string
{

    case Positive_Support = 'positive';
    case Negative_Discount = 'negative';

    public function label(): string
    {
        return match($this) {
            self::Positive_Support => 'دعم إيجابي',
            self::Negative_Discount => 'حسم سلبي',
        };
    }
}


