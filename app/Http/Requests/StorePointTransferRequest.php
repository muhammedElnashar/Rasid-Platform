<?php

namespace App\Http\Requests;

use App\Rules\ValidTransferAmount;
use Illuminate\Foundation\Http\FormRequest;

class StorePointTransferRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'reason'      => 'required|string',
            'amount'      => [
                'required',
                'integer',
                'min:1',
                'max:100',
                new ValidTransferAmount($this->user()),
            ],
            'purpose'     => 'required|string',
        ];
    }
}
