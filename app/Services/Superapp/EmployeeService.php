<?php

namespace App\Services\Superapp;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EmployeeService
{
    public $loggedUser;

    public function __construct()
    {
        $this->loggedUser = Auth::user();
    }

   public function getAll(int $page = 1, int $perPage = 10, ?string $search = null, ?string $position = null): array
{
    $user  = Auth::user(); // ambil fresh di sini
    $token = Cache::get('user_token_' . $user?->id);
    
    // dd($token, $user?->id); // hapus dd ini sekarang

    $queryParams = array_filter([
        'page'     => $page,
        'per_page' => $perPage,
        'search'   => $search,
        'position' => $position,
    ]);

    $response = SuperappService::requestWithToken(
        url: '/employees',
        token: $token,
        method: 'GET',
        queryParams: $queryParams,
    );

    return $response->json() ?? [];
}

    public function getAsOption(?string $position = null): array
    {
        $token = Cache::get('user_token_' . $this->loggedUser?->id);

        $response = SuperappService::requestWithToken(
            url: '/employees/options',
            token: $token,
            method: 'GET',
            queryParams: array_filter([
                'position' => $position,
            ]),
        );

        return $response->json()['data'] ?? [];
    }
}