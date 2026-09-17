<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstallerLock
{
    public function handle(Request $request, Closure $next): Response
    {
        $lockPath = storage_path('framework/installed');

        if (file_exists($lockPath)) {
            abort(404);
        }

        return $next($request);
    }
}