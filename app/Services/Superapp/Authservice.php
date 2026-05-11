<?php

namespace App\Services\Superapp;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthService
{
    public $loggedUser;

    public function __construct()
    {
        $this->loggedUser = Auth::user();
    }

    public function getMe(?string $token = null): ?array
    {
        $token = Cache::get('user_token_' . $this->loggedUser?->id) ?? $token;

        $cacheKey = 'me_' . md5($token);
        $ttl = 300;

        $cached = Cache::get($cacheKey);
        if ($cached) {
            return json_decode($cached, true);
        }

        $response = SuperappService::requestWithToken(
            url: '/auth/me',
            token: $token,
            method: 'GET',
        );

        if ($response->failed()) {
            if ($response->status() === 401) {
                Cache::forget($cacheKey);
                Auth::logout();
                session()->invalidate();
            }
            return null;
        }

        $data = $response->json()['data'] ?? null;
        if ($data) {
            Cache::put($cacheKey, json_encode($data), $ttl);
        }

        return $data;
    }
}