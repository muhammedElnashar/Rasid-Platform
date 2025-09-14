<?php

namespace App\Http\Requests;

use App\Enum\DeductionCardTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDeductionCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation()
    {
        if ($this->type === DeductionCardTypeEnum::Alert->value) {
            $this->merge([
                'deduction_percent' => 0,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'color' => 'required|hex_color',
            'description' => 'nullable|string|max:1000',
            'threshold' => 'required|integer',
            'type' => ['required', Rule::in(array_column(DeductionCardTypeEnum::cases(), 'value'))],

            'deduction_percent' => [
                Rule::requiredIf(fn () => $this->type !== DeductionCardTypeEnum::Alert->value),
                'integer',
                Rule::when($this->type !== DeductionCardTypeEnum::Alert->value, [
                    'min:1',
                    'max:100',
                ]),
            ],
        ];
    }
}
