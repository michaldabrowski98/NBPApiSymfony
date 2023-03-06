<?php

namespace App\Enum;

interface NBPApiTableNamesInterface
{
    public const TABLE_A = 'A';
    public const TABLE_B = 'B';

    public const NBP_TABLES = [
        self::TABLE_A,
        self::TABLE_B
    ];
}