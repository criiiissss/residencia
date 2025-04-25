<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Level3Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()) {
            if(auth()->user()->rol == 'level3'){
                return $next($request);
            }
            else{
                return redirect()->to('/modulos')->withErrors(['message' => 'NO SE CUENTA CON LOS PERMISOS NECESARIOS PARA REALIZAR OPERACIONES DE NIVEL 3']);
            }
        }
        else{
            return redirect()->to('/')->withErrors(['message' => 'NO SE ENCUENTRA CON UNA SESION INICIADA']);
        }
    }
}
