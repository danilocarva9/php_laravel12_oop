<?php

namespace Modules\Order\Exceptions;

use App\Exceptions\BaseException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OrderNotFoundException extends BaseException
{
    protected $code = Response::HTTP_NOT_FOUND;
    protected $message = 'Order not found.';

    public function report(): void
    {
        // You can log the exception or send notifications here
        Log::warning('Failed login attempt detected.');
    }
}
