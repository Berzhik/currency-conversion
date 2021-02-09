<?php

namespace App\Http\Controllers;

use App\Contracts\Conversion\ProviderInterface;
use App\Http\Requests\Conversion\FormRequest;
use App\Repository\Currency\ExchangeHistoryRepository;
use Exception;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @var ProviderInterface
     */
    private $conversionProvider;

    /**
     * @var ExchangeHistoryRepository
     */
    private $exchangeHistoryRepository;

    /**
     * @param ProviderInterface $conversionProvider
     * @param ExchangeHistoryRepository $exchangeHistoryRepository
     */
    public function __construct(
        ProviderInterface $conversionProvider,
        ExchangeHistoryRepository $exchangeHistoryRepository
    ) {
        $this->conversionProvider = $conversionProvider;
        $this->exchangeHistoryRepository = $exchangeHistoryRepository;
    }

    public function homepage()
    {
        $currencies = $this->conversionProvider->getAvailableCurrencies();

        return view('page.homepage', [
            'currencies' => $currencies
        ]);
    }

    public function convert(FormRequest $formRequest)
    {
        $formData = $formRequest->validated();
        $result = $this->conversionProvider->convertCurrency($formData);
        $this->exchangeHistoryRepository->addRecord($formData);

        return view('page.conversion-result', [
            'value' => $result
        ]);
    }

    public function statistics()
    {
        try {
            $mostPopular = $this->exchangeHistoryRepository->mostPopularDestination();
        } catch (Exception $e) {
            $mostPopular = $e->getMessage();
        }

        return view('page.statistics', [
            'most_popular' => $mostPopular,
            'total_converted' => $this->getTotalConverted(),
            'total_requests' => $this->exchangeHistoryRepository->totalRequests()
        ]);
    }

    /**
     * @return float
     */
    private function getTotalConverted()
    {
        $usdRates = $this->conversionProvider->getRatesForCurrency()['rates'];
        $exchanges = $this->exchangeHistoryRepository->getAllRecords();
        $totalAmount = 0;

        foreach ($exchanges as $record) {
            $totalAmount += (1 / $usdRates[$record['source']]) * $record['amount'];
        }

        return $totalAmount;
    }
}
