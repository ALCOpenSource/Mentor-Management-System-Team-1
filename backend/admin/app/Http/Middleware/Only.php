<?php

namespace App\Http\Middleware;

use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Only
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param mixed $roles
     */
    public function handle(Request $request, \Closure $next, $roles): Response
    {
        if (! $request->user() || ! $request->user()->hasRole($roles)) {
            return new ApiResource([
                'error' => 'You are not authorized to access this resource.',
                'status' => 403,
            ]);
        }

        return $next($request);
    }
}
