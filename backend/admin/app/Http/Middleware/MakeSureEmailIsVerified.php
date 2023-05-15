<?php

namespace App\Http\Middleware;

use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MakeSureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, \Closure $next): Response|ApiResource
    {
        if (! $request->user()->hasVerifiedEmail()) {
            return new ApiResource([
                'error' => 'Your email address is not verified.',
                'status' => 403,
            ]);
        }

        return $next($request);
    }
}
