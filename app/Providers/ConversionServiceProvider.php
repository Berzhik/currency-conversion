<?php

namespace App\Providers;

use App\Containers\Conversion\OpenExchangeRates;
use App\Contracts\Conversion\ProviderInterface;
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
        $this->app->bind(ProviderInterface::class, OpenExchangeRates::class);
    }
}
