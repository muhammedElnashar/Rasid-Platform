<?php

namespace App\Enum;

enum PurposeEnum:string
{
    case Gift = 'gift';
    case Reward = 'reward';
    case Friendship = 'friendship';
    case Appreciation = 'appreciation';
    case Another = 'another';
}
