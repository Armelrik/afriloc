<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedPromoterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (!$request->user()->hasRole('promoter')) {
            abort(403, 'Unauthorized');
        }

        $promoteur = $request->user()->promoteur;
        if ($promoteur->statut !== 'VALIDE') {
            return redirect()->route('promoter.pending')
                ->with('warning', __('Your account is pending approval. You will be notified once approved.'));
        }

        return $next($request);
    }
}
