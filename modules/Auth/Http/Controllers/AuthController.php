<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Actions\LoginAction;
use Modules\Auth\Actions\LogoutAction;
use Modules\Auth\Actions\RegisterAction;
use Modules\Auth\Http\Requests\AuthLoginRequest;
use Modules\Auth\Http\Requests\AuthRegisterRequest;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request, RegisterAction $registerAction)
    {
        $registerAction->handle($request->validated());
        return response()->json(['message' => 'Registration successful']);
    }

    public function login(AuthLoginRequest $request, LoginAction $loginAction)
    {
        $token = $loginAction->handle($request->validated());

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request, LogoutAction $logoutAction)
    {
        $logoutAction->handle($request);
        return response()->json(['message' => 'Logout successful']);
    }
}
