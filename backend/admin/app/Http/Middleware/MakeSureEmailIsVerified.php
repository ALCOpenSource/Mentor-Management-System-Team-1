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
    public function handle(Request $request, \Closure $next): Response
    {
        if (! $request->user()->hasVerifiedEmail()) {
            return new ApiResource([
                'message' => 'Your email address is not verified.',
            ], 403);
        }

        return $next($request);
    }
}
