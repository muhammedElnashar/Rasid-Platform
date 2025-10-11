<?php

namespace App\Services;

use App\Models\Insignia;
use App\Models\UserInsignia;
use App\Traits\HasIssuedModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InsigniaService
{
    use HasIssuedModel; // ✅ استدعاء الـ Trait هنا

    public function assignInsignia(array $data): void
    {

        DB::transaction(function () use ($data) {
            $insignia = Insignia::findOrFail($data['insignia_id']);
            $issuedModel = $this->getIssuedModel($data['issued_to_type'], $data['issued_to_id']);

            $alreadyExists = UserInsignia::where('issued_to_id', $issuedModel->id)
                ->where('issued_to_type', $data['issued_to_type'])
                ->where('insignia_id', $insignia->id)
                ->exists();

            if ($alreadyExists) {
                throw ValidationException::withMessages([
                    'insignia_id' => __('هذه الشارة مضافة مسبقًا لهذا المستخدم أو المجموعة.'),
                ]);
            }
            UserInsignia::create([
                'issued_to_id'   => $data['issued_to_id'],
                'issued_to_type' => $data['issued_to_type'],
                'insignia_id'    => $insignia->id,
                'issuer_id'      => $data['issuer_id'],
                'award_date'     => $data['award_date'],
            ]);

            $this->applyPoints($issuedModel, $insignia->points_value);
        });
    }

    private function applyPoints($model, int $points): void
    {
        if ($model->isFillable('fixed_points') && $model->isFillable('flexible_points')) {
            $model->increment('fixed_points', $points);
            $model->increment('flexible_points', $points);
        }
    }
}
