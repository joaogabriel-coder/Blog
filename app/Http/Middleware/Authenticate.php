<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle unauthenticated requests.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            abort(response()->json([
                'message' => 'Não autenticado.'
            ], 401));
        }

        return null;
    }
}
