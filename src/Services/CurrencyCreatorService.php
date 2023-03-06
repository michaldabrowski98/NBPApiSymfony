<?php

namespace App\Services;

use App\Entity\Currency;
use Money\Money;
use Money\Currency as MoneyCurrency;


class CurrencyCreatorService
{
    public function createCurrencyFromArray(array $currency): Currency
    {
        $currencyEntity = new Currency();
        $currencyEntity->setName($currency['currency']);
        $currencyEntity->setCurrencyCode($currency['code']);
        $currencyEntity->setExchangeRate($this->getMoneyObject($currency));

        return $currencyEntity;
    }

    public function getMoneyObject(array $currency): Money
    {
        return new Money(
            (int) ($currency['mid'] * 100000000),
            new MoneyCurrency($currency['code'])
        );
    }
}
