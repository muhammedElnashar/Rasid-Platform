<?php

namespace App\Enum;

enum StatusEnum:string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Rejected = 'rejected';
}
