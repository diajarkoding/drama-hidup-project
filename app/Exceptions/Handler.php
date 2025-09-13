<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            $status = 500;
            $message = $e->getMessage();
            $errors = null;

            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                $status = 401;
                $message = 'Unauthenticated.';
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                $status = 422;
                $message = 'Validation failed';
                $errors = $e->errors();
            } elseif ($e instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
                return $e->getResponse();
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                $status = $e->getStatusCode();
            }

            return response()->json([
                'status' => 'error',
                'message' => $message ?: 'Something went wrong.',
                'errors' => $errors,
            ], $status);
        }

        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticated.',
            'errors' => null,
        ], 401);
    }
}
