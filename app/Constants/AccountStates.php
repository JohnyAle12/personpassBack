<?php

namespace App\Constants;

enum AccountStates : string
{
    case AVAILABLE = 'available';
    case FROZEN = 'frozen';
    case CLOSED = 'closed';
    case NOTAVAILABLE = 'notavailable';

    public static function values(): array
    {
        return [
            self::AVAILABLE->value,
            self::FROZEN->value,
            self::CLOSED->value,
            self::NOTAVAILABLE->value
        ];
    }
}