<?php

namespace App\Containers\Conversion;

use App\Contracts\Conversion\ProviderInterface;
use Exception;
use Illuminate\Support\Facades\Http;

class ExchangeRatesApi implements ProviderInterface
{
    const API_ENDPOINT = 'https://api.exchangeratesapi.io/';

    /**
     * @inheritDoc
     */
    public function getAvailableCurrencies()
    {
        $latestRates = $this->processRequest('latest');

        /**
         * The endpoint returns rates of other currencies to the base currency
         * Thus, all available currency is the combination of 
         * currencies from rates and the base currency
         * 
         * Base currency is EUR by default
         */
        $availableCurrencies = array_merge(
            [$latestRates['base']],
            array_keys($latestRates['rates'])
        );

        return array_combine($availableCurrencies, $availableCurrencies);
    }

    /**
     * @inheritDoc
     */
    public function getRatesForCurrency($baseCurrency = ProviderInterface::USD_CURRENCY)
    {
        return $this->processRequest('latest', [
            'base' => $baseCurrency
        ]);
    }

    /**
     * @inheritDoc
     */
    public function convertCurrency($formData)
    {
        $conversionRate = $this->processRequest('latest', [
            'base' => $formData['source'],
            'symbols' => $formData['destination']
        ]);

        $rate = $conversionRate['rates'][$formData['destination']];

        return $rate * $formData['amount'];
    }

    /**
     * @param string $path
     * @param array $data
     * @return array
     */
    private function processRequest($path, $data = [])
    {
        $request = Http::get(self::API_ENDPOINT . $path, $data);

        if (!$request->successful()) {
            throw new Exception('The service is unavailable right now. Try a bit later');
        }

        return $request->json();
    }
}