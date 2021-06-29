<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class CheckLocalization
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
        // Check Localization
        if ($request->hasHeader('accept-language')) {
            $locale = $request->header('accept-language');

            if (!Str::contains($locale, ['id', 'en']) || Str::length($locale) > 2) {
                return ResponseFormatter::error(['message' => 'if Header contain accept-language, the value must be id/en']);
            }

            App::setLocale($locale);
        }

        return $next($request);
    }
}
