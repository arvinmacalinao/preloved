<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Check if the user is a superadmin
        if (auth()->user()->u_is_superadmin) {
            return $next($request);
        }
        
        // Check if the user is a store manager
        if ($role === 'storemanager' && auth()->user()->u_is_store_manager) {
            return $next($request);
        }

        // Check if the user is a superadmin
        if ($role === 'admin' && auth()->user()->u_is_admin) {
            return $next($request);
        }

        // Check if the user is a superadmin
        if ($role === 'productowner' && auth()->user()->u_is_owner) {
            return $next($request);
        }

        // If the user doesn't have the required role, redirect them or show an error
        return redirect()->route('home')->with('error', 'Access denied.');
    }
}
