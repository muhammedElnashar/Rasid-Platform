<?php

namespace Database\Seeders;

use App\Enum\CardNameEnum;
use Illuminate\Database\Seeder;
use App\Models\Card;
use App\Models\CardCategory;
use App\Models\CardItem;
use App\Models\School;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::first() ?? School::create([
            'name' => 'مدرسة الهدى',
            'location' => 'الإسكندرية',
            'email' => 'info@elhoda.edu.eg',
            'phone' => '01098765432',
            'ministerial_number' => 'MN-2001',
        ]);

        // الكرت الأول: الدعم الإيجابي
        $positiveCard = Card::create([
            'school_id' => $school->id,
            'name' => CardNameEnum::Positive_Support,
        ]);

        $positiveCategory = CardCategory::create([
            'card_id' => $positiveCard->id,
            'name' => 'سلوك إيجابي',
        ]);

        $positiveItems = [
            ['name' => 'مساعدة زملاءه', 'points' => 10],
            ['name' => 'الالتزام بالمواعيد', 'points' => 15],
            ['name' => 'احترام المعلم', 'points' => 20],
        ];

        foreach ($positiveItems as $item) {
            CardItem::create([
                'card_category_id' => $positiveCategory->id,
                'name' => $item['name'],
                'points' => $item['points'],
            ]);
        }

        // الكرت الثاني: الحسم السلبي
        $negativeCard = Card::create([
            'school_id' => $school->id,
            'name' => CardNameEnum::Negative_Discount,
        ]);

        $negativeCategory = CardCategory::create([
            'card_id' => $negativeCard->id,
            'name' => 'سلوك سلبي',
        ]);

        $negativeItems = [
            ['name' => 'تأخير عن الطابور', 'points' => -5],
            ['name' => 'إهمال الواجب', 'points' => -10],
            ['name' => 'سلوك غير لائق', 'points' => -20],
        ];

        foreach ($negativeItems as $item) {
            CardItem::create([
                'card_category_id' => $negativeCategory->id,
                'name' => $item['name'],
                'points' => $item['points'],
            ]);
        }
    }
}
