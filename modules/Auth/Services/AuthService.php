<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Exceptions\FailedLoginException;
use Modules\Customer\Models\Customer;

class AuthService
{

    /**
     * Handle user registration.
     *
     * @param array $request
     * @return void
     */
    public function register(array $request): void
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        Customer::firstOrCreate([
            'user_id' => $user->id,
            'first_name' => strtok($request['name'], ' '),
            'last_name' => substr($request['name'], strrpos($request['name'], ' ') + 1)
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

    /**
     * Handle user logout by deleting the current access token.
     *
     * @param mixed $request
     * @return void
     */
    public function logout($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
