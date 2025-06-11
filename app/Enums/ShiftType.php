<?php
namespace App\Enums;

enum ShiftType: string {
    case WFO = 'WFO';
    case WFH = 'WFH';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
