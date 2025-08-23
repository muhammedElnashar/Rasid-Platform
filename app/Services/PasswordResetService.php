<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\CustomResetPassword;

class PasswordResetService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }
    public function sendResetLink(User $user): void
    {
        $token = app('auth.password.broker')->createToken($user);
        $user->notify(new CustomResetPassword($token));
    }
}
