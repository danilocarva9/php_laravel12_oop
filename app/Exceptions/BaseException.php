<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class BaseException extends Exception
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
    protected $message = 'An error occurred.';

    public function render(): Response
    {
        $response = [
            'status' => 'error',
            'code' => $this->code,
            'message' => $this->message,
        ];

        if (config('app.debug')) {
            $response['stack'] = $this->getTrace();
        }

        return response()->json($response, $this->code);
    }
}
