<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the super admin role
        if (!auth()->user()->isSuperAdmin()){
            // If not, redirect to the home page with an error message
            return redirect()->route('home')->with('error', __('message.unauthorized_access'));
        }
        return $next($request);
    }
}
