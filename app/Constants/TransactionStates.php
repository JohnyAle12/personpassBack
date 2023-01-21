<?php

namespace App\Constants;

enum TransactionStates : string
{
    case SUCCESS = 'success';
    case FAILED = 'failes';
    case PROCESSING = 'processing';
    case DENIED = 'denied';

    public static function values(): array
    {
        return [
            self::SUCCESS->value,
            self::FAILED->value,
            self::PROCESSING->value,
            self::DENIED->value
        ];
    }
}