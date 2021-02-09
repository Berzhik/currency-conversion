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
        try {
            $currencies = $this->conversionProvider->getAvailableCurrencies();
        } catch (Exception $e) {
            return view('page.homepage', [
                'error' => $e->getMessage()
            ]);
        }

        return view('page.homepage', [
            'currencies' => $currencies
        ]);
    }

    public function convert(FormRequest $formRequest)
    {
        $formData = $formRequest->validated();
        try {
            $result = $this->conversionProvider->convertCurrency($formData);
        } catch (Exception $e) {
            return view('page.conversion-result', [
                'result' => $e->getMessage()
            ]);
        }

        $this->exchangeHistoryRepository->addRecord($formData);

        return view('page.conversion-result', [
            'result' => $result
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
     * @return float|string
     */
    private function getTotalConverted()
    {
        try {
            $usdRates = $this->conversionProvider->getRatesForCurrency()['rates'];
        } catch (Exception $e) {
            return 'The data cannot be calculated right now. Try a bit later';
        }

        $exchanges = $this->exchangeHistoryRepository->getAllRecords();
        $totalAmount = 0;

        foreach ($exchanges as $record) {
            if (empty($usdRates[$record['source']])) {
                continue;
            }

            $totalAmount += (1 / $usdRates[$record['source']]) * $record['amount'];
        }

        return $totalAmount;
    }
}
