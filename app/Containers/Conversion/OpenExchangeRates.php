<?php

namespace App\Containers\Conversion;

use App\Contracts\Conversion\ProviderInterface;
use Exception;
use Illuminate\Support\Facades\Http;

/**
 * @todo The development of this class was not completed due to the need for a paid subscription
 */
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
        $request = Http::get(self::API_ENDPOINT . 'currencies.json');

        if (!$request->successful()) {
            throw new Exception($request->body());
        }

        return $request->json();
    }

    /**
     * @inheritDoc
     */
    public function convertCurrency($formData)
    {
        $request = Http::get(self::API_ENDPOINT . 'convert', [
            'value' => $formData['amount'],
            'from' => $formData['source'],
            'to' => $formData['destination'],
            'app_id' => $this->appId
        ]);

        if (!$request->successful()) {
            throw new Exception($request->body());
        }

        return $request['response'];
    }

    /**
     * @todo implement the function
     */
    public function getRatesForCurrency()
    {

    }
}