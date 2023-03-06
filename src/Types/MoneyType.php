<?php

declare(strict_types=1);

namespace App\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Money\Money;

class MoneyType extends Type
{
    private const NAME = 'money';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'money';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Money) {
            $value = (string) $value->getAmount();
        }

        return $value;
    }

    public function canRequireSQLConversion()
    {
        return true;
    }

    public function getName()
    {
        return self::NAME;
    }
}
