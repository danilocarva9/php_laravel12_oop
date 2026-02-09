<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\User\Models\User;

abstract class TestCase extends BaseTestCase
{

    /**
     * Act as authenticated user
     *
     * @param User $user
     * @param string|null $guard
     * @return void
     */
    protected function actAsUser(User $user, ?string $guard = 'sanctum'): void
    {
        $this->actingAs($user, $guard);
    }
}
