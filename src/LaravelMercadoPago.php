<?php

namespace Germanlozickyj\LaravelMercadoPago;

use Exception;
use Germanlozickyj\LaravelMercadoPago\Exceptions\MercadoPagoApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class LaravelMercadoPago
{
    const API_URL = 'https://api.mercadopago.com';

    public static function api(
        string $method, 
        string $uri, 
        array $payload = []
    )
    {
        if (empty(config('mercado-pago.access_token'))) {
            throw new Exception('The mercado pago access token must be configured');
        }
        $access_token = config('mercado-pago.access_token');
        
        $response = Http::withToken($access_token)
            ->accept('application/json')
            ->contentType('application/json')
            ->$method(static::API_URL."/$uri", $payload);
        
        static::handleStatusCode($response);

        return static::handleResponse($response);
    }

    public static function handleStatusCode(Response $response)
    {
        if($response->status() == 400) {
            throw new MercadoPagoApiException('Error status 400 Response: ' . $response->body());
        }
        if($response->status() == 500) {
            throw new MercadoPagoApiException('Error status 500 Response: ' . $response->body());
        }
    }

    public static function handleResponse(Response $response)
    {
        return $response->json();
    }
}
