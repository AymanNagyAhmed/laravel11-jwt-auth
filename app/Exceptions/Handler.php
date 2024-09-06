<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        dd('here');
        if ($exception instanceof AuthenticationException) {
            // Handle authentication exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed.',
                'code' => 401,
            ], 401);
        }
        // Handle other exceptions
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        dd('here');
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
}
