<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\Exceptions\FailedLoginException;
use Modules\User\Models\User;

class Login
{
    /**
     * Handle user login and return an authentication token.
     *
     * @param array $payload
     * @return string
     * @throws FailedLoginException
     */
    public function handle(array $payload): string
    {
        $user = User::where('email', $payload['email'])->first();

        if (!$user || !Hash::check($payload['password'], $user->password)) {
            throw new FailedLoginException();
        }

        $user->tokens()->delete();

        return $user->createToken('auth_token')->plainTextToken;
    }
}
