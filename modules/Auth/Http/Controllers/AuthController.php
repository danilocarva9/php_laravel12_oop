<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\AuthLoginRequest;
use Modules\Auth\Http\Requests\AuthRegisterRequest;
use Modules\Auth\Services\LoginService;

class AuthController extends Controller
{

    public function __construct(private LoginService $loginService) {}

    public function register(AuthRegisterRequest $request)
    {
        $this->loginService->register($request->validated());
        return response()->json(['message' => 'Registration successful']);
    }

    public function login(AuthLoginRequest $request)
    {
        $token = $this->loginService->login($request->validated());

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $this->loginService->logout($request);
        return response()->json(['message' => 'Logout successful']);
    }
}
