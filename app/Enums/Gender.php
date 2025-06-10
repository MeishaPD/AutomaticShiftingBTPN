<?php
namespace App\Enums;

enum Gender: string {
    case MALE   = 'Laki Laki';
    case FEMALE = 'Perempuan';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
