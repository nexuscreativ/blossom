<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInstalled
{
    /**
     * Redirect to the installer until the application has been installed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $installed = filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN)
            || file_exists(storage_path('app/installed'));

        $isInstallRoute = $request->routeIs('install.*');

        if (! $installed && ! $isInstallRoute) {
            return redirect()->route('install.index');
        }

        if ($installed && $isInstallRoute) {
            // The completion page is safe to view even when installed.
            if ($request->routeIs('install.complete')) {
                return $next($request);
            }

            return redirect()->route('home');
        }

        return $next($request);
    }
}