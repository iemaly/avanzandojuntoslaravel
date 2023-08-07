<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $requestedUserId = $request->route('id');
        $authenticatedUserId = auth()->id();

        if ($requestedUserId != $authenticatedUserId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
