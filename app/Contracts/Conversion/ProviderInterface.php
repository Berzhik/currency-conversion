<?php

namespace App\Contracts\Conversion;

interface ProviderInterface
{
    const USD_CURRENCY = 'USD';

    /**
     * Receive associative array of available currencies 
     * format [currency_code => currency_title]
     * 
     * @return array
     */
    public function getAvailableCurrencies();

    /**
     * @param array $formData
     * @return int
     */
    public function convertCurrency($formData);

    /**
     * @param string $baseCurrency
     * @return array
     */
    public function getRatesForCurrency($baseCurrency = self::USD_CURRENCY);
}