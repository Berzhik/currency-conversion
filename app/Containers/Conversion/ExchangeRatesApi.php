<?php

namespace App\Containers\Conversion;

use App\Contracts\Conversion\ProviderInterface;
use App\Contracts\Http\AdapterInterface;

class ExchangeRatesApi implements ProviderInterface
{
    const API_ENDPOINT = 'https://api.exchangeratesapi.io/';

    /**
     * @var AdapterInterface
     */
    private $httpAdapter;

    /**
     * @param AdapterInterface $httpAdapter
     */
    public function __construct(
        AdapterInterface $httpAdapter
    ) {
        $this->httpAdapter = $httpAdapter;
    }

    /**
     * @inheritDoc
     */
    public function getAvailableCurrencies()
    {
        $latestRates = $this->httpAdapter->sendRequest(self::API_ENDPOINT . 'latest', 'GET');

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
        return $this->httpAdapter->sendRequest(self::API_ENDPOINT . 'latest', 'GET', [
            'base' => $baseCurrency
        ]);
    }

    /**
     * @inheritDoc
     */
    public function convertCurrency($formData)
    {
        $conversionRate =  $this->httpAdapter->sendRequest(self::API_ENDPOINT . 'latest', 'GET', [
            'base' => $formData['source'],
            'symbols' => $formData['destination']
        ]);

        $rate = $conversionRate['rates'][$formData['destination']];

        return $rate * $formData['amount'];
    }
}