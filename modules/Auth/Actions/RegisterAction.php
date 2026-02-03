<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

class RegisterAction
{
    /**
     * Handle user registration.
     *
     * @param array $payload
     * @return void
     */
    public function handle(array $payload): void
    {
        DB::transaction(function () use ($payload) {
            $user = User::create([
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => Hash::make($payload['password']),
            ]);

            $user->customer()->firstOrCreate([
                'first_name' => strtok($payload['name'], ' '),
                'last_name' => substr($payload['name'], strrpos($payload['name'], ' ') + 1)
            ]);
        });
    }
}
