<?php

namespace App\Services\Superapp;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class JurusanService
{
    public function getAll(int $page = 1, int $perPage = 10, ?string $search = null): ?array
    {
        $user = Auth::user();
        $token = Cache::get('user_token_' . $user?->id);

        if (empty($token)) {
            return null;
        }

        $queryParams = array_filter([
            'page'     => $page,
            'per_page' => $perPage,
            'search'   => $search,
        ]);

        $response = SuperappService::requestWithToken(
            url: '/jurusan',
            token: $token,
            method: 'GET',
            queryParams: $queryParams,
        );

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
