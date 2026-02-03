<?php

namespace Modules\Auth\Actions;

class LogoutAction
{
    /**
     * Handle user logout by deleting the current access token.
     *
     * @param mixed $request
     * @return void
     */
    public function handle($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
