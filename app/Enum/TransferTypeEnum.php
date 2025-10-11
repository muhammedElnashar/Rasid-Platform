<?php

namespace App\Enum;

enum TransferTypeEnum:string
{
    case GroupToGroup = 'GroupToGroup';
    case UserToUser = 'UserToUser';
    public function label(): string
    {
        return match($this) {
            self::GroupToGroup => 'مجموعه',
            self::UserToUser => 'مستخدم',
        };
    }
}
