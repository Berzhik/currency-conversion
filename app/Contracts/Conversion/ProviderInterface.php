<?php

namespace App\Contracts\Conversion;

interface ProviderInterface
{
    /**
     * @return array
     */
    public function getAvailableCurrencies();
}