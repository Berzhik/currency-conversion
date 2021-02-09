<?php

namespace App\Http\Controllers;

use App\Contracts\Conversion\ProviderInterface;
use App\Http\Requests\Conversion\FormRequest;
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

    public function convert(FormRequest $formRequest)
    {
        $result = $this->conversionProvider->convertCurrency($formRequest->validated());

        return view('page.conversion-result', [
            'value' => $result['response']
        ]);
    }
}
