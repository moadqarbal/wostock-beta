<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToInstaller
{
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |--------------------------------------------------------------------------
        | Application is not installed
        |--------------------------------------------------------------------------
        */

        if (!file_exists(storage_path('framework/installed'))) {

            /*
            |--------------------------------------------------------------------------
            | Allow installer routes
            |--------------------------------------------------------------------------
            */

            if ($request->is('install') || $request->is('install/*')) {
                return $next($request);
            }

            /*
            |--------------------------------------------------------------------------
            | Lock the entire application
            |--------------------------------------------------------------------------
            */

            return redirect()->route('installer.requirements');
        }

        return $next($request);
    }
}