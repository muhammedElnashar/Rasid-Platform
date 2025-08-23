<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateSchoolAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255|unique:users,username,' . $this->route('admin')->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $this->route('admin')->id,
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols(),],
            'phone'    => 'nullable|string|max:15',
        ];
    }
}
