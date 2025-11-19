<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            // Rediriger vers la page de connexion appropriée selon le rôle requis
            if ($role === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect('/login');
        }

        if (!auth()->user()->hasRole($role)) {
            // Si l'utilisateur est connecté mais n'a pas le bon rôle
            abort(403, 'Accès non autorisé. Vous n\'avez pas les permissions nécessaires.');
        }

        return $next($request);
    }
}
