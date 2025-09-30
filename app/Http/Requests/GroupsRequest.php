<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GroupsRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'leader_id' => 'required|exists:users,id',
            'user_id' => 'required|array|min:1',
            'user_id.*' => 'exists:users,id',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();

            // تحقق من أن القائد موجود ضمن الأعضاء
            if (
                isset($data['leader_id'], $data['user_id'])
                && !in_array($data['leader_id'], $data['user_id'])
            ) {
                $validator->errors()->add('leader_id', 'القائد يجب أن يكون أحد أعضاء المجموعة');
            }

            if (isset($data['user_id']) && is_array($data['user_id'])) {
                foreach ($data['user_id'] as $userId) {
                    $exists = Group::whereHas('members', function ($q) use ($userId) {
                        $q->where('users.id', $userId);
                    })
                        ->when($this->group, function ($q) {
                            $q->where('id', '!=', $this->group->id);
                        })
                        ->exists();

                    if ($exists) {
                        $user = User::find($userId);
                        $name = $user ? $user->full_name : "مستخدم (ID: $userId)";

                        $validator->errors()->add(
                            'user_id',
                            "  المستخدم  {$name}  موجود بالفعل في مجموعة  أخرى "
                        );
                    }
                }
            }
        });
    }}
