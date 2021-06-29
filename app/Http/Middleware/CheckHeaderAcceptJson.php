<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Http\Request;

class CheckHeaderAcceptJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check Header
        if ($request->header('accept') !== 'application/json') {
            return ResponseFormatter::error(['message' => 'Header must contain Accept and contains value application/json']);
        }

        return $next($request);
    }
}
