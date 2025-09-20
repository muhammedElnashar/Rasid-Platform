<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardIssueRequest extends FormRequest
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
            'user_id'          => ['required', 'exists:users,id'],
            'card_item_id'     => ['required', 'exists:card_items,id'],
            'deduction_type'     => ['nullable', 'in:immediate,deferred'],
            'deduction_duration_days' => ['nullable', 'integer', 'required_if:deduction_type,deferred'],
            'is_restricted'   => ['nullable', 'boolean'],
        ];
    }
}
