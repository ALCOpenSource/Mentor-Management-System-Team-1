<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordSessionActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $response = $next($request);

        // If user is authenticated, record data in the user table
        if ($request->user()) {
            addUserSession($request);
        }

        return $response;
    }
}
