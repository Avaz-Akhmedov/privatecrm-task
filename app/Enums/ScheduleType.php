<?php

namespace App\Enums;

enum ScheduleType: string
{
    case EVERY_DAY = 'EVERY_DAY';
    case EVERY_OTHER_DAY = 'EVERY_OTHER_DAY';
    case EVERY_OTHER_DAY_TWICE = 'EVERY_OTHER_DAY_TWICE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
