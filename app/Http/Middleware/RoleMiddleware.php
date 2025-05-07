<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifie si l'utilisateur est authentifié et a le bon rôle
        if (Auth::check() && Auth::user()->role !== $role) {
            // Redirige vers une page d'erreur ou autre si l'utilisateur n'a pas le rôle
            return redirect('/login');
        }

        return $next($request);
    }
}
