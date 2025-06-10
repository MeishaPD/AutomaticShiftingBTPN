<?php
namespace App\Enums;

enum Location: string {
    case MENARA_BTPN    = 'Menara BTPN';
    case KEBAYORAN_BARU = 'Kebayoran Baru';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
