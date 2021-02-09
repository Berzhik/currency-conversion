<?php

namespace App\Contracts\Conversion;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getAvailableCurrencies();

    /**
     * @param array $formData
     * @return int
     */
    public function convertCurrency($formData);
}