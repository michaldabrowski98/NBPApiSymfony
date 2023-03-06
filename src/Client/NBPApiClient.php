<?php

namespace App\Client;

use App\Enum\NBPApiTableNamesInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NBPApiClient
{
    private const NBP_API_URL = 'http://api.nbp.pl';

    private HttpClientInterface $client;

    private LoggerInterface $logger;

    public function __construct(
        HttpClientInterface $client,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function fetchCurrenciesInformation(): array
    {
        $currencies = [];
        foreach (NBPApiTableNamesInterface::NBP_TABLES as $NBPTable) {
            $currencies += $this->fetchCurrencyByTableName($NBPTable);
        }

        return $currencies;
    }

    private function fetchCurrencyByTableName(string $tableName): array
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('%s/api/exchangerates/tables/%s', self::NBP_API_URL, $tableName)
            );

            if (200 !== $response->getStatusCode()) {
                $this->logger->alert(sprintf('API returned status %s', $response->getStatusCode()));
                return [];
            }

            $responseContent = $response->getContent();
        } catch (HttpExceptionInterface | TransportExceptionInterface $e) {
            $this->logger->critical('An error occurred while fetching data from API', [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);

            return [];
        }

        return $this->getCurrenciesArray($responseContent);
    }

    private function getCurrenciesArray(string $responseContent): array
    {
        $arrayContent = json_decode($responseContent, true);

        if (!isset($arrayContent[0]) || !isset($arrayContent[0]['rates'])) {
            return [];
        }

        $results = $arrayContent[0]['rates'];

        $currencies = [];
        foreach ($results as $result) {
            $currencies[$result['code']] = $result;
        }

        return $currencies;
    }
}