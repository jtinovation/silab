<?php

namespace App\Http\Controllers\Auth;

use App\Dtos\Auth\UserLoginInfoDto;
use App\Dtos\Auth\UserLoginResponseDto;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Superapp\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OAuthController extends Controller
{
    public function redirect()
    {
        return redirect(
            config('app.super_app_url') . '/oauth/authorize?' . http_build_query([
                'client_id'     => config('auth.oauth.client_id'),
                'redirect_uri'  => route('auth.callback'),
                'response_type' => 'code',
            ])
        );
    }

    public function callback(Request $request)
    {
        $response = Http::asForm()->post(config('app.super_app_url_internal') . '/oauth/token', [
            'grant_type'    => 'authorization_code',
            'client_id'     => config('auth.oauth.client_id'),
            'client_secret' => config('auth.oauth.client_secret'),
            'redirect_uri'  => route('auth.callback'),
            'code'          => $request->code,
        ]);

        if ($response->failed()) {
            return redirect()->route('login')->withErrors([
                'msg' => $response->json('message') ?? 'Login failed. Please try again.'
            ]);
        }

        $data  = $response->json();
        $roles = $data['data']['user']['roles'] ?? [];

        $dto = new UserLoginResponseDto(
            token: $data['data']['token'],
            user: new UserLoginInfoDto(
                id: $data['data']['user']['id'],
                name: $data['data']['user']['name'],
                email: $data['data']['user']['email'],
                roles: $roles,
                permissions: $data['data']['user']['permissions'] ?? null,
            ),
        );

        $authData = app(AuthService::class)->getMe($dto->token);

        $nimNidn  = null;
        $photoUrl = null;

        if (!in_array('student', $roles)) {
            $detail   = $authData['employee_detail'] ?? [];
            $nimNidn  = $detail['nip'] ?? null;
            $photoUrl = $detail['photo_url'] ?? null;
        } else {
            $detail   = $authData['student_detail'] ?? [];
            $nimNidn  = $detail['nim'] ?? null;
            $photoUrl = $detail['img_path'] ?? null;
        }

        $user = User::updateOrCreate(
    ['external_id' => $dto->user->id],
    [
        'name'      => $dto->user->name,
        'email'     => $dto->user->email,
        'password'  => bcrypt('oauth-no-password'),
        'is_aktif'  => 1,
        'photo_url' => $photoUrl,
        'nim_nidn'  => $nimNidn,
        'user_type' => in_array('student', $roles)
            ? 'student'
            : (in_array('dosen', $roles) ? 'lecturer' : 'other'),
    ]
);

        Auth::login($user);

        // Assign role default jika belum punya role
        if ($user->getRoleNames()->isEmpty()) {
            $user->assignRole('Teknisi');
        }

        Cache::put('user_token_' . $user->id, $dto->token, 43200);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        Cache::forget('user_token_' . $userId);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->away(
            config('app.super_app_url') . '/oauth/logout?redirect=' . route('login')
        );
    }
} 