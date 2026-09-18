<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * Expects to run after the "admin" middleware, which already verified
     * that the user is authenticated and is an admin.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next, string $module)
    {
        if (!Auth::user()->hasModuleAccess($module)) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
