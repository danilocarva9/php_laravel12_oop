<?php

namespace Modules\Auth\Exceptions;

use App\Exceptions\BaseException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FailedLoginException extends BaseException
{
    protected $code = Response::HTTP_UNAUTHORIZED;
    protected $message = 'Invalid credentials.';

    public function report(): void
    {
        // You can log the exception or send notifications here
        Log::warning('Failed login attempt detected.');
    }
}
