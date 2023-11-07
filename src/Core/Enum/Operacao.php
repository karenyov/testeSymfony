<?php

namespace App\Core\Enum;

enum Operacao: string
{
    case INSERT_ACTION = 'I';
    case UPDATE_ACTION = 'U';
    case DELETE_ACTION = 'D';

    public static function getValues(): array
    {
        return [
            self::INSERT_ACTION,
            self::UPDATE_ACTION,
            self::DELETE_ACTION,
        ];
    }
}
