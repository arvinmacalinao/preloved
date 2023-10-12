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
    
        // Check if the user has the required role
        $hasRequiredRole = false;
        switch ($role) {
            case 'storemanager':
                $hasRequiredRole = auth()->user()->u_is_store_manager;
                break;
            case 'admin':
                $hasRequiredRole = auth()->user()->u_is_admin;
                break;
            case 'productowner':
                $hasRequiredRole = auth()->user()->u_is_owner;
                break;
        }
    
        if ($hasRequiredRole) {
            return $next($request);
        }
    
        // Set the session message
        $request->session()->put('session_msg', 'Your account does not have privilege for this action.');
    
        // Redirect to the home route
        return redirect()->route('home');
    }
}
