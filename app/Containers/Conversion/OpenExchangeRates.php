<?php

namespace App\Containers\Conversion;

use App\Contracts\Conversion\ProviderInterface;
use Exception;
use Illuminate\Support\Facades\Http;

class OpenExchangeRates implements ProviderInterface
{
    const API_ENDPOINT = 'https://openexchangerates.org/api/';

    /**
     * @var string
     */
    private $appId;

    public function __construct()
    {
        $this->appId = config('conversion.open_exchange_rates.app_id');
    }

    /**
     * @inheritDoc
     */
    public function getAvailableCurrencies()
    {
        $request = Http::get(self::API_ENDPOINT . 'curarencies.json');

        return $request->json();
    }
}