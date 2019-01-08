<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Socialite;
use App\User;

trait SocialiteAuthenticatesUsers
{
    public function redirectToProvider(string $platform)
    {
        return Socialite::driver($platform)->stateless()->redirect();
    }

    public function handleProviderCallback(string $platform)
    {
        $userInfo = Socialite::driver($platform)->stateless()->user();

        $user = $this->create($userInfo, $platform);

        $user->markEmailAsVerified();

        $token = $user->createToken('Passport Token')->accessToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function create($userInfo, string $platform)
    {
        return User::firstOrCreate(
            ["{$platform}_id" => $userInfo->id],
            [
                'username' => $userInfo->nickname,
                'email' => $userInfo->email,
                'avatar' => $userInfo->avatar
            ]
        );
    }
}
