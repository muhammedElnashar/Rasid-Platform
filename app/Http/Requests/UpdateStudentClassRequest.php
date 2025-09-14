<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'exists:users,id',
                Rule::unique('student_classes')
                    ->where(function ($query) {
                        return $query->where('student_id', $this->student_id)
                            ->where('class_id', $this->class_id)
                            ->where('subject_id', $this->subject_id);
                    })
                    ->ignore($this->route('student_class')),
            ],
            'class_id' => [
                'required',
                'exists:classes,id',
            ],
            'subject_id' => [
                'required',
                'exists:subjects,id',
            ],
        ];
    }
}
