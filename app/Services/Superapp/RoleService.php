<?php

namespace App\Services\Superapp;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RoleService
{
    public function getAll(int $page = 1, int $perPage = 10, ?string $search = null): array
    {
        $user  = Auth::user();
        $token = Cache::get('user_token_' . $user?->id);

        $queryParams = array_filter([
            'page'     => $page,
            'per_page' => $perPage,
            'search'   => $search,
        ]);

        $response = SuperappService::requestWithToken(
            url: '/roles',
            token: $token,
            method: 'GET',
            queryParams: $queryParams,
        );

        return $response->json() ?? [];
    }
}