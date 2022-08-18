<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

use App\Models\User;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $oauthUser    = Socialite::driver('google')->user();
            $user       = User::where('email', $oauthUser->getEmail())->first();
        if ($user == null) {
            $data_create = [
                'name' => $oauthUser->name,
                'email' => $oauthUser->email,
                'avatar' => $oauthUser->avatar,
                'google_id'=> $oauthUser->id,
                'role' => 2,
                // password tidak akan digunakan ;)
                'password' => Hash::make($oauthUser->token),
            ];

            $newUser = User::create($data_create);
            Auth::login($newUser);
        } else {
            if($user->google_id == null){
                $data_update = [
                    'google_id' => $oauthUser->id,
                    'avatar' => $oauthUser->avatar,
                ];
                User::where('email', $oauthUser->email)->update($data_update);
            }

            Auth::loginUsingId($user->id);
        }

       /*  if(auth()->user()->role == 3){
            return redirect(route('index'));
        } else {
            return redirect(route('manage'));
        } */

        return redirect()->route('dashboard');
    }
}
