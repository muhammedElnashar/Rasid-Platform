<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAwardRequest extends FormRequest
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
            'image_url'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'points_required'=>'required|integer|min:1',
            'stock'=> 'required|integer|min:0',
            'target_role'=>'nullable|exists:roles,id',
            'target_level_id'=>'nullable|exists:levels,id',
        ];
    }
}
