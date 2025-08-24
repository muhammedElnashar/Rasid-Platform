<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;

class UserServices
{
    protected PasswordResetService $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function createUser(array $data, ?int $schoolId = null): User
    {
        $schoolId = $schoolId ?? auth()->user()->school_id ?? null;

        $role = Role::findOrFail($data['role_id']);
        $rolePrefix = substr($role->name, 0, 2);

        do {
            $randomNumber = rand(1000, 9999);
            $username = Str::lower($rolePrefix . $randomNumber);
        } while (User::where('username', $username)->exists());

        $user = User::create([
            'username'  => $username,
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? null,
            'role_id'   => $role->id,
            'school_id' => $schoolId,
            'password'  => bcrypt(Str::random(16)),
        ]);

        $this->passwordResetService->sendResetLink($user);

        return $user;
    }
}
