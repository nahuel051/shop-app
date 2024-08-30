<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('auth'); // Redirige a la ruta 'auth' si no está autenticado
        }

        return $next($request);
    }
    protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        return route('auth');
    }
}

}
