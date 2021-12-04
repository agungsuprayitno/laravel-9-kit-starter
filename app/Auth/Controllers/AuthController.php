<?php

namespace App\Auth\Controllers;

use App\Auth\Requests\SignInRequest;
use App\Auth\Services\AuthService;
use App\Http\Controllers\Controller;
use League\Fractal\Manager;

class AuthController extends Controller
{
    public function __construct(
        protected Manager $fractal,
        protected AuthService $authService
    ){}

    public function signIn(SignInRequest $request){

        $user = $this->authService->signIn($request);

        return response()->json($user);
    }

    public function signOut()
    {
        $this->authService->signOut();
        return response()->json(true);
    }
}
