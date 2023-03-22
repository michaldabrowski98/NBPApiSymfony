<?php

namespace App\Command;

use App\Services\CurrencyExchangeRateUpdateService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-currency-exchange-rates',
    description: 'Import currency exchange rates.',
    hidden: false,
)]
class ImportCurrencyExchangeRatesCommand extends Command
{
    private CurrencyExchangeRateUpdateService $currencyExchangeRateUpdateService;

    public function __construct(CurrencyExchangeRateUpdateService $currencyExchangeRateUpdateService)
    {
        parent::__construct();
        $this->currencyExchangeRateUpdateService = $currencyExchangeRateUpdateService;
    }


    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Currencies exchange rate import start.');
        $this->currencyExchangeRateUpdateService->updateExchangeRates();
        $output->writeln('Currencies exchange rate finish!');

        return Command::SUCCESS;
    }
}
