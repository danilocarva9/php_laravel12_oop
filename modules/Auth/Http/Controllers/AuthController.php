<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\AuthLoginRequest;
use Modules\Auth\Http\Requests\AuthRegisterRequest;
use Modules\Auth\Services\AuthService;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService) {}

    public function register(AuthRegisterRequest $request)
    {
        $this->authService->register($request->validated());
        return response()->json(['message' => 'Registration successful']);
    }

    public function login(AuthLoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return response()->json(['message' => 'Logout successful']);
    }
}
