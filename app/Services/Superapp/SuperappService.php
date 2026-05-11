<?php

namespace App\Services\Superapp;

use Illuminate\Support\Facades\Http;

class SuperappService
{
    public static function requestWithToken($url, $token, $method = 'GET', $data = [], $queryParams = []): \Illuminate\Http\Client\Response | \GuzzleHttp\Promise\PromiseInterface
    {
        $baseUrl = config('app.super_app_url_internal');

        if (config('app.env') !== 'production') {
            $baseUrl = config('app.super_app_url');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->withQueryParameters($queryParams);

        if (strtoupper($method) === 'POST') {
            $response = $response->post($baseUrl . $url, $data);
        } else if (strtoupper($method) === 'PUT') {
            $response = $response->put($baseUrl . $url, $data);
        } else if (strtoupper($method) === 'DELETE') {
            $response = $response->delete($baseUrl . $url, $data);
        } else {
            $response = $response->get($baseUrl . $url, $data);
        }

        return $response;
    }
}
