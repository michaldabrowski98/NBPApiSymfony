<?php

namespace App\tests\unit\Services;

use App\Entity\Currency;
use App\Services\CurrencyCreatorService;
use PHPUnit\Framework\TestCase;

class CurrencyCreatorServiceTest extends TestCase
{
    public function testCreateCurrencyFromArray(): void
    {
        $service = new CurrencyCreatorService();
        $result = $service->createCurrencyFromArray(
            [
                'currency' => 'dolar amerykański',
                'code' => 'USD',
                'mid' => 4.3715
            ]
        );

        self::assertEquals($this->getCurrencyEntity(), $result);
    }

    private function getCurrencyEntity(): Currency
    {
        $currencyEntity = new Currency();
        $currencyEntity->setName('dolar amerykański');
        $currencyEntity->setCurrencyCode('USD');
        $currencyEntity->setExchangeRate('4.3715');

        return $currencyEntity;
    }
}
