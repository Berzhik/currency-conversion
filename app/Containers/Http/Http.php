<?php

namespace App\Containers\Http;

use App\Contracts\Http\AdapterInterface;
use Exception;
use Illuminate\Support\Facades\Http as FacadesHttp;

class Http implements AdapterInterface
{
    /**
     * @inheritDoc
     */
    public function sendRequest($url, $method, $params = [])
    {
        $response = FacadesHttp::send($method, $url, $params);

        if (!$response->successful()) {
            throw new Exception('The service is unavailable right now. Try a bit later');
        }

        return $response->json();
    }
}