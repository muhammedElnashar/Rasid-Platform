<?php

namespace App\Enum;

enum DeductionTypeEnum:string
{
    case Immediate= 'immediate';
    case Deferred= 'deferred';
}
