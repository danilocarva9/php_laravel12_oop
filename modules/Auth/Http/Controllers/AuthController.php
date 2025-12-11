<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\AuthLoginRequest;
use Modules\Auth\Http\Requests\AuthRegisterRequest;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        // Registration logic here
        return response()->json(['message' => 'Registration successful']);
    }

    public function login(AuthLoginRequest $request)
    {
        // Login logic here
        return response()->json(['message' => 'Login successful']);
    }
}
