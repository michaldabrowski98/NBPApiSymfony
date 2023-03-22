<?php

namespace App\Services;

use App\Client\NBPApiClient;
use App\Entity\Currency;
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
        $currencies = $this->NBPApiClient->fetchCurrenciesInformation();
        foreach ($currencies as $currency) {
            $currencyEntity = $this->entityManager->getRepository(Currency::class)->findOneBy([
                'currencyCode' => $currency['code'],
            ]);

            $this->entityManager->persist($this->getCurrencyEntity($currencyEntity, $currency));
        }

        $this->entityManager->flush();
    }

    private function getCurrencyEntity(?Currency $currencyEntity, array $currency): Currency
    {
        if ($currencyEntity instanceof Currency) {
            $currencyEntity->setExchangeRate((string) $currency['mid']);
        } else {
            $currencyEntity = $this->currencyCreatorService->createCurrencyFromArray($currency);
        }
        return $currencyEntity;
    }
}
