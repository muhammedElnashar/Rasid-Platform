<?php

namespace App\Http\Requests;

use App\Enum\DeductionCardTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeductionCardRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'color'=>'required|hex_color',
            'description'=>'nullable|string|max:1000',
            'deduction_percent'=>'required|integer|min:1|max:100',
            'threshold'=>'required|integer',
            'type' => ['required', Rule::in(DeductionCardTypeEnum::cases())],
        ];
    }
}
