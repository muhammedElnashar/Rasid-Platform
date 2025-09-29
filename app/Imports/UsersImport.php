<?php

namespace App\Imports;

use App\Models\User;
use App\Services\UserServices;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    protected UserServices $userServices;
    protected ?int $schoolId;
    public array $newUsers = [];

    public function __construct(?int $schoolId = null)
    {
        $this->userServices = App::make(UserServices::class);
        $this->schoolId = $schoolId;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'role_id' => 'required|in:3,4,5,6',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'full_name.required' => 'الاسم مطلوب.',
            'full_name.string'   => 'يجب أن يكون الاسم نصاً.',
            'email.required'     => 'البريد الإلكتروني مطلوب.',
            'email.email'        => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'       => 'البريد الإلكتروني مكرر.',
            'role_id.required'   => 'الدور مطلوب.',
            'role_id.in' => 'الدور يجب أن يكون طالب (3) أو معلم (4) أو ولي امر (5) أو مشرف (6)',
        ];
    }

    public function model(array $row)
    {
        $user = $this->userServices->createUser([
            'full_name' => $row['full_name'],
            'email'     => $row['email'],
            'role_id'   => $row['role_id'],
        ], $this->schoolId);

        $this->newUsers[] = $user;
        return $user;
    }
}
