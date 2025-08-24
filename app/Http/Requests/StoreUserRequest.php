<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|string|max:15',
            'role_id'   => 'required|integer|exists:roles,id',
            'school_name' => 'required_if:role_id,2|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'school_name.required_if' => 'حقل المدرسه مطلوب لانشاء مدير جديد.',
        ];
    }
}
