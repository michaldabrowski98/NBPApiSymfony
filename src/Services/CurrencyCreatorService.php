<?php

namespace App\Services;

use App\Entity\Currency;

class CurrencyCreatorService
{
    public function createCurrencyFromArray(array $currency): Currency
    {
        $currencyEntity = new Currency();
        $currencyEntity->setName($currency['currency']);
        $currencyEntity->setCurrencyCode($currency['code']);
        $currencyEntity->setExchangeRate($currency['mid']);

        return $currencyEntity;
    }
}
