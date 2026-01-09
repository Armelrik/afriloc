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
            if (str_contains($role, 'admin')) {
                return redirect()->route('admin.login');
            }
            return redirect('/login');
        }

        // Gérer plusieurs rôles séparés par des virgules
        $roles = explode(',', $role);
        $roles = array_map('trim', $roles); // Supprimer les espaces
        
        $hasRequiredRole = false;
        foreach ($roles as $requiredRole) {
            if (auth()->user()->hasRole($requiredRole)) {
                $hasRequiredRole = true;
                break;
            }
        }

        if (!$hasRequiredRole) {
            // Si l'utilisateur est connecté mais n'a aucun des rôles requis
            abort(403, 'Accès non autorisé. Vous n\'avez pas les permissions nécessaires.');
        }

        return $next($request);
    }
}
