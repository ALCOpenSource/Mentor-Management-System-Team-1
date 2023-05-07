<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if ($request->user()) {
            $timezone = $request->user()->timezone;

            if ($timezone) {
                config(['app.timezone' => $timezone]);
            }
        }

        return $next($request);
    }
}
