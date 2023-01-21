<?php

namespace App\Constants;

enum TransactionTypes : string
{
    case ACCREDIT = 'accredit';
    case DISCREDIT = 'discredit';

    public static function values(): array
    {
        return [
            self::ACCREDIT->value,
            self::DISCREDIT->value
        ];
    }
}