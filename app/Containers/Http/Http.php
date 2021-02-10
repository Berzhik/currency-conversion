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
        switch ($method) {
            case 'POST': 
                $response = FacadesHttp::post($url, $params);
                break;

            case 'GET':
                $response = FacadesHttp::get($url, $params);
                break;

            default:
                throw new Exception('Check the method');
        }

        if (!$response->successful()) {
            throw new Exception('The service is unavailable right now. Try a bit later');
        }

        return $response->json();
    }
}