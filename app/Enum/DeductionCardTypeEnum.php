<?php

namespace App\Enum;

enum DeductionCardTypeEnum:string
{
    case Alert = 'alert';
    case Warning = 'warning';
    case Deduct = 'deduct';
}
