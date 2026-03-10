<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si no está autenticado, redirigir al login con mensaje
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder al panel de administración.');
        }

        // Regenerar ID de sesión para prevenir ataques de fijación de sesión
        $request->session()->regenerate();

        return $next($request);
    }
}
