<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

trait RegistersUsers
{
    /**
     * Handle a registration request
     * @param  Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        $token = $user->createToken('Passport Token')->accessToken;

        return response()->json([
            'token' => $token
        ]);
    }
}
