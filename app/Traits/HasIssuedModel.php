<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Group;
use Illuminate\Validation\ValidationException;

trait HasIssuedModel
{
    /**
     * استرجاع الموديل المناسب (User أو Group) بناءً على النوع والمعرف.
     *
     * @param string $type الكلاس الكامل مثل App\Models\User أو App\Models\Group
     * @param int $id معرف السجل
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function getIssuedModel(string $type, int $id)
    {
        return match ($type) {
            User::class  => User::findOrFail($id),
            Group::class => Group::findOrFail($id),
            default      => throw ValidationException::withMessages([
                'issued_to_type' => __("النوع المحدد غير صالح: {$type}"),
            ]),
        };
    }
}
