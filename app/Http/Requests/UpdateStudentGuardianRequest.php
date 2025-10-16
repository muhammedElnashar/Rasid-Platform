<?php

namespace App\Http\Requests;

use App\Enum\RelationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentGuardianRequest extends FormRequest
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
        // هذا هو الـ id الخاص بسجل الطالب/الولي الحالي (student_guardian)
        $guardianRecordId = $this->route('student_guardian');

        return [
            'student_id' => [
                'required',
                'exists:users,id',
            ],

            // لا يسمح بتكرار نفس الولي مع نفس الطالب
            'guardian_id' => [
                'required',
                'exists:users,id',
                Rule::unique('student_guardians')
                    ->ignore($guardianRecordId) // تجاهل السجل الحالي أثناء التحقق
                    ->where(fn($q) => $q->where('student_id', $this->student_id)),
            ],

            // لا يسمح بتكرار نفس العلاقة مع نفس الطالب
            'relationship' => [
                'required',
                'string',
                'max:255',
                Rule::in(array_column(RelationEnum::cases(), 'value')),
                Rule::unique('student_guardians')
                    ->ignore($guardianRecordId)
                    ->where(fn($q) => $q->where('student_id', $this->student_id)),
            ],
        ];
    }}
