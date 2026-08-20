<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremium
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasActiveSubscription()) {
            return redirect()->route('pricing')->with('error', 'This content is for BLOSSOM Premium subscribers. Subscribe to unlock it.');
        }

        return $next($request);
    }
}