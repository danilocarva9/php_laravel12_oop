<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Actions\Login;
use Modules\Auth\Actions\Logout;
use Modules\Auth\Actions\Register;
use Modules\Auth\Http\Requests\AuthLoginRequest;
use Modules\Auth\Http\Requests\AuthRegisterRequest;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request, Register $register)
    {
        $register->handle($request->validated());
        return response()->json(['message' => 'Registration successful']);
    }

    public function login(AuthLoginRequest $request, Login $login)
    {
        $token = $login->handle($request->validated());

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request, Logout $logout)
    {
        $logout->handle($request);
        return response()->json(['message' => 'Logout successful']);
    }
}
