<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLogsRequest extends FormRequest
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
        $type = $this->input('issued_to_type');

        return [
            'issued_to_type' => ['required', Rule::in(['App\Models\User', 'App\Models\Group'])],
            'issued_to_id' => [
                'required',
                $type === 'App\Models\User'
                    ? Rule::exists((new User)->getTable(), 'id')
                    : Rule::exists((new Group)->getTable(), 'id'),
            ], 'card_item_id' => 'required|exists:card_items,id',
            'active' => 'nullable|boolean',
        ];
    }
}
