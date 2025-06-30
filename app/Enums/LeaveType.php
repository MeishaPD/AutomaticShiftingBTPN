<?php
namespace App\Enums;

enum LeaveType: string {
    case YEARLY  = 'yearly';
    case SPECIAL = 'special';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
