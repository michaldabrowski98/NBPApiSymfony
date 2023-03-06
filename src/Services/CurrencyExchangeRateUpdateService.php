<?php

declare(strict_types=1);

namespace App\Services;

use App\Client\NBPApiClient;
use App\Entity\Currency;
use App\Types\MoneyType;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyExchangeRateUpdateService
{
    private EntityManagerInterface $entityManager;

    private CurrencyCreatorService $currencyCreatorService;

    private NBPApiClient $NBPApiClient;

    public function __construct(
        EntityManagerInterface $entityManager,
        CurrencyCreatorService $currencyCreatorService,
        NBPApiClient $NBPApiClient
    ) {
        $this->entityManager = $entityManager;
        $this->currencyCreatorService = $currencyCreatorService;
        $this->NBPApiClient = $NBPApiClient;
    }

    public function updateExchangeRates(): void
    {
        Type::addType('money', MoneyType::class);
        $this->entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('money', 'money');
        $currencies = $this->NBPApiClient->fetchCurrenciesInformation();
        foreach ($currencies as $currency) {
            $currencyEntity = $this->entityManager->getRepository(Currency::class)->findOneBy([
                'currencyCode' => $currency['code'],
            ]);

            $this->entityManager->persist($this->getCurrencyEntity($currencyEntity, $currency));
        }

        $this->entityManager->flush();
    }

    private function getCurrencyEntity(?Currency $currencyEntity, mixed $currency): array|Currency
    {
        if ($currencyEntity instanceof Currency) {
            $currencyEntity->setExchangeRate($this->currencyCreatorService->getMoneyObject($currency));
        } else {
            $currencyEntity = $this->currencyCreatorService->createCurrencyFromArray($currency);
        }
        return $currencyEntity;
    }
}
