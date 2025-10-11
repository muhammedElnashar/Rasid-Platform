<?php

namespace App\Services;

use App\Jobs\SendPasswordResetLinkJob;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
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

        do {
            $settlementCode = rand(10000000, 99999999);
        } while (User::where('settlement_code', $settlementCode)->exists());
        $user = User::create([
            'username'  => $username,
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'] ?? null,
            'role_id'   => $role->id,
            'school_id' => $schoolId,
            'password'  => bcrypt(Str::random(16)),
            'settlement_code' => $settlementCode,
        ]);

        dispatch(new SendPasswordResetLinkJob($user));

        return $user;
    }
    public function suspendUser(User $user)
    {
        $user->status = false;
        $user->save();
        DB::table('sessions')->where('user_id', $user->id)->delete();
    }
    public function activateUser(User $user)
    {
        DB::table('recharge_failed_attempts')->where('issued_to_id', $user->id)->delete();
        $user->status = true;
        $user->save();

    }
}
