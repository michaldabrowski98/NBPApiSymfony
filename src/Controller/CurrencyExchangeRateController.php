<?php

namespace App\Controller;

use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyExchangeRateController extends AbstractController
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    #[Route('/', name: 'list_controller')]
    public function listCurrenciesAction(Request $request): Response
    {
        $pageNumber = $request->get('page') ?? 1;
        return $this->render(
            'CurrencyExchangeRate/currencies.html.twig',
            [
                'currencies' => $this->currencyRepository->getCurrenciesWithPagination($pageNumber),
                'pageNumber' => $pageNumber,
            ]
        );
    }
}
