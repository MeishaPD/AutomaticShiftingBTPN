<?php
namespace App\Enums;

enum ShiftStatus: string {
    case APROVED  = 'approved';
    case REJECTED = 'rejected';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
