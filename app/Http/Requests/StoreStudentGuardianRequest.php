<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentGuardianRequest extends FormRequest
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
            'student_id' => 'required|exists:users,id',
            'guardian_id' => ['required', 'exists:users,id', Rule::unique('student_guardians')
                ->where(fn($q) => $q->where('student_id', $this->student_id)),
                ],
            'relationship' => ['required', 'string', 'max:255', Rule::unique('student_guardians')
                ->where(fn($q) => $q->where('student_id', $this->student_id)),
            ],
        ];
    }
}
