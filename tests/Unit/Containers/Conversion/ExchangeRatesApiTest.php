<?php

namespace Tests\Unit\Repository\Currency;

use App\Containers\Conversion\ExchangeRatesApi;
use App\Containers\Http\Http;
use App\Contracts\Conversion\ProviderInterface;
use App\Contracts\Http\AdapterInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class ExchangeRatesApiTest extends TestCase
{
    /**
     * @return void
     */
    public function test_available_currencies()
    {
        $mock = $this->mock(Http::class);
        $mock->shouldReceive('sendRequest')
            ->andReturn([
                'rates' => [
                    'CAD' => 1,
                    'HKD' => 2,
                    'ISK' => 3,
                    'PHP' => 4,
                    'DKK' => 5
                ],
                'base' => 'EUR'
            ]);

        $conversionProvider = new ExchangeRatesApi($mock);
        $currencies = $conversionProvider->getAvailableCurrencies();

        $this->assertEquals([
            'EUR' => 'EUR',
            'CAD' => 'CAD',
            'HKD' => 'HKD',
            'ISK' => 'ISK',
            'PHP' => 'PHP',
            'DKK' => 'DKK'
        ], $currencies);
    }

    /**
     * @return void
     */
    public function test_convert_currency()
    {
        $mock = $this->mock(Http::class);
        $mock->shouldReceive('sendRequest')
            ->andReturn([
                'rates' => [
                    'AUD' => 1.4
                ]
            ]);

        $conversionProvider = new ExchangeRatesApi($mock);
        $convertedValue = $conversionProvider->convertCurrency([
            'source' => 'USD',
            'destination' => 'AUD',
            'amount' => 100
        ]);

        $this->assertEquals(140, $convertedValue);
    }
}
