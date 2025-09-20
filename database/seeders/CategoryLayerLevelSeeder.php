<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Layer;
use App\Models\Level;

class CategoryLayerLevelSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'فئة الفرسان',
            'فئة الأبطال',
            'فئة الملوك',
        ];

        $pointsCounter = 0; // يبدأ من الصفر ويتراكم

        foreach ($categories as $catName) {
            $category = Category::create([
                'school_id' => 1, // غيّر حسب المدرسة عندك
                'name' => $catName,
            ]);

            $layers = [
                ['name' => 'الطبقة الأولى',  'reward_value' => 300],
                ['name' => 'الطبقة الثانية', 'reward_value' => 200],
                ['name' => 'الطبقة الثالثة','reward_value' => 100],
            ];

            foreach ($layers as $layerData) {
                $layer = $category->layers()->create($layerData);

                // 10 مستويات لكل طبقة
                for ($i = 1; $i <= 10; $i++) {
                    $pointsCounter += 100; // كل مستوى يزيد 100 نقطة عن السابق

                    Level::create([
                        'layer_id' => $layer->id,
                        'name' => "المستوى $i",
                        'points_required' => $pointsCounter,
                        'reward_value' => $i * 10, // مكافأة بسيطة تزيد تدريجياً
                    ]);
                }
            }
        }
    }
}
