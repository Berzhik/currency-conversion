<?php

namespace App\Contracts\Http;

interface AdapterInterface
{
    /**
     * @param string $url
     * @param string $method
     * @param array $params
     * @return array
     */
    public function sendRequest($url, $method, $params = []);
}