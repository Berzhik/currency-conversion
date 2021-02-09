<?php

namespace App\Http\Controllers;

use App\Contracts\Conversion\ProviderInterface;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @var ProviderInterface
     */
    private $conversionProvider;

    /**
     * @param ProviderInterface $conversionProvider
     */
    public function __construct(
        ProviderInterface $conversionProvider
    ) {
        $this->conversionProvider = $conversionProvider;
    }

    public function homepage()
    {
        $currencies = $this->conversionProvider->getAvailableCurrencies();

        return view('page.homepage', [
            'currencies' => $currencies
        ]);
    }
}
