<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsGestao
{
    /**
     * Permite o acesso apenas para usuários com perfil de gestão (admin/gestao).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isGestao()) {
            abort(403, 'Acesso restrito a usuários de gestão.');
        }

        return $next($request);
    }
}
