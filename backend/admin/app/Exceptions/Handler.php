<?php

namespace App\Exceptions;

use App\Http\Resources\ApiResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (\Throwable $e) {
            if (request()->is('api/*')) {
                return new ApiResource([
                    'status' => 500,
                    'error' => $e->getMessage(),
                ]);
            }
        });

        /*
         * Render an exception into an HTTP response.
         *
         * @see https://stackoverflow.com/questions/68516285/customize-laravel-sanctum-unauthorize-response
         */
        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return new ApiResource([
                    'status' => 401,
                    'error' => $e->getMessage(),
                ]);
            }
        });
    }
}
