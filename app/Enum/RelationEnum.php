<?php

namespace App\Enum;

enum RelationEnum:string
{
    case Father = 'father';
    case Mother = 'mother';
    case Brother = 'brother';
    case Paternal_Uncle = 'paternal_uncle';
    case Maternal_Uncle = 'maternal_uncle';
    case Grandfather = 'grandfather';
    case Guardian = 'guardian';

    public function label(): string
    {
        return match($this) {
            self::Father => 'الأب',
            self::Mother => 'الأم',
            self::Brother => 'الأخ',
            self::Paternal_Uncle => 'العم',
            self::Maternal_Uncle => 'الخال',
            self::Grandfather => 'الجد',
            self::Guardian => 'الوصي',
        };
    }
}
