<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Stage;
use App\Models\Grade;
class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::create([
            'name' => 'مدرسة النور',
            'location' => 'القاهرة',
            'email' => 'info@elnour.edu.eg',
            'phone' => '01012345678',
            'logo' => null,
            'documents' => null,
            'ministerial_number' => 'MN-1001',
        ]);

        // إضافة مراحل
        $stages = [
            'المرحلة الابتدائية',
            'المرحلة الإعدادية',
            'المرحلة الثانوية',
        ];

        foreach ($stages as $stageName) {
            $stage = Stage::create([
                'school_id' => $school->id,
                'name' => $stageName,
            ]);

            // إضافة صفوف لكل مرحلة
            $grades = match ($stageName) {
                'المرحلة الابتدائية' => ['الصف الأول', 'الصف الثاني', 'الصف الثالث'],
                'المرحلة الإعدادية'  => ['الأول الإعدادي', 'الثاني الإعدادي', 'الثالث الإعدادي'],
                'المرحلة الثانوية'    => ['الأول الثانوي', 'الثاني الثانوي', 'الثالث الثانوي'],
                default               => [],
            };

            foreach ($grades as $gradeName) {
                $grade = Grade::create([
                    'stage_id' => $stage->id,
                    'name' => $gradeName,
                ]);

                // إضافة فصول لكل صف
                foreach (['A', 'B', 'C'] as $className) {
                    Classes::create([
                        'grade_id' => $grade->id,
                        'name' => "فصل $className",
                    ]);
                }
            }
        }
    }
}
