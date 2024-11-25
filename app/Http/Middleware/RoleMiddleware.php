<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the authenticated user has the specified role
        if (Auth::check() && Auth::user()->role_id == $role) {
            return $next($request);
        }

        // Redirect or throw a 403 error for unauthorized access
        abort(403, 'Unauthorized action.');
    }   
  



}
