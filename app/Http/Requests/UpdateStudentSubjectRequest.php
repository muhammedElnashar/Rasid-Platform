<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentSubjectRequest extends FormRequest
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
        $id = $this->route('student_subject');

        return [
            'student_id' => 'required|exists:users,id',
            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('student_subjects')
                    ->where(fn($q) => $q->where('student_id', $this->student_id))
                    ->ignore($id),
            ],
        ];
    }
}
