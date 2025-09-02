<?php

namespace App\Enum;

enum StatusCardEnum:string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Rejected = 'rejected';
}
