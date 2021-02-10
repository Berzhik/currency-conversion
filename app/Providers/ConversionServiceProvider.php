<?php

namespace App\Providers;

use App\Containers\Conversion\ExchangeRatesApi;
use App\Containers\Http\Http;
use App\Contracts\Conversion\ProviderInterface;
use App\Contracts\Http\AdapterInterface;
use Illuminate\Support\ServiceProvider;

class ConversionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProviderInterface::class, ExchangeRatesApi::class);

        $this->app->bind(AdapterInterface::class, Http::class);
    }
}
