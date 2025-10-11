<?php

namespace App\Http\Requests;

use App\Models\Group;
use App\Models\User;
use App\Rules\ValidTransferAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePointTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation()
    {
        $receiverType = $this->input('receiver_type');

        // نحدد نوع المرسل بناءً على نوع المستلم
        $senderType = $receiverType === 'App\Models\User'
            ? 'App\Models\User'
            : 'App\Models\Group';

        // نحدد الـ ID للمرسل
        $senderId = $senderType === 'App\Models\User'
            ? Auth::id()
            : ($this->input('sender_id'));

        // ندمجهم في الطلب قبل التحقق
        $this->merge([
            'sender_type' => $senderType,
            'sender_id'   => $senderId,
        ]);
    }

    /**
     * 🔹 قواعد التحقق
     */
    public function rules(): array
    {
        $senderType = $this->input('sender_type');
        $receiverType = $this->input('receiver_type');

        // نحدد كائن المرسل بشكل مباشر للاستخدام في القاعدة
        $sender = $senderType === 'App\Models\User'
            ? Auth::user()
            : Group::findOrFail($this->input('sender_id'));

        return [
            'sender_type'   => ['required', Rule::in(['App\Models\User', 'App\Models\Group'])],
            'sender_id'     => ['required', 'integer'],
            'receiver_type' => ['required', Rule::in(['App\Models\User', 'App\Models\Group'])],
            'receiver_id'   => [
                'required',
                $receiverType === 'App\Models\User'
                    ? Rule::exists((new User)->getTable(), 'id')
                    : Rule::exists((new Group)->getTable(), 'id'),
            ],
            'reason'        => 'required|string|max:255',
            'purpose'       => 'required|string|max:255',
            'amount'        => [
                'required',
                'integer',
                'min:1',
                new ValidTransferAmount($sender), // ✅ مباشرة هنا
            ],
        ];
    }
}
