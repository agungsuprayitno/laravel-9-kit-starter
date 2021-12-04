<?php
namespace App\Auth\Services;

use App\Auth\Exceptions\InvalidUsernameOrPasswordException;
use App\Auth\Models\UsersModel;
use App\Auth\Requests\SignInRequest;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function signIn(SignInRequest $request) {

        $user = UsersModel::where('email', $request->username)->first();

        if (! $user)
            throw new InvalidUsernameOrPasswordException();

        $tokenCreated = $user->createToken($request->username)->plainTextToken;
        
        $tokenResponse['token_type'] = "Bearer";
        $tokenResponse['access_token'] = $tokenCreated;
        $tokenResponse['user'] = [
            'id' => $user->id,
            'name' => $user->name
        ];

        return $tokenResponse;
    }

    public function signOut()
    {
        Auth::user()->tokens()->delete();
    }
}