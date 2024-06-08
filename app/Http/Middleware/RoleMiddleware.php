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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        
        if(!$user)
        {
          return redirect('/')->withErrors(['message' => 'You need to log in to access this page.']);
        }

        if($user->hasRole($role))
        {
            return $next($request);
        }

        return redirect('/dashboard')->withErrors(['message' => 'You do not have permission to access this page.']);
    }
}
