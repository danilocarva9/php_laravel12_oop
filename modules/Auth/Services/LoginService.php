<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Exceptions\FailedLoginException;

class LoginService
{

    /**
     * Handle user registration.
     *
     * @param array $request
     * @return void
     */
    public function register(array $request): void
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Handle user login and return an authentication token.
     *
     * @param array $request
     * @return string
     * @throws FailedLoginException
     */
    public function login(array $request): string
    {
        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            throw new FailedLoginException();
        }

        $user->tokens()->delete();

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
