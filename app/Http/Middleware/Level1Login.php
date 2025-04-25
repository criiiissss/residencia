<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Level1Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()) {
            if(auth()->user()->rol == 'level1' || auth()->user()->rol == 'level2' || auth()->user()->rol == 'level3'){
                return $next($request);
            }
            else{
                return redirect()->to('/modulos')->withErrors(['message' => 'NO SE CUENTA CON LOS PERMISOS CORRECTOS']);;
            }
        }
        else{
            return redirect()->to('/')->withErrors(['message' => 'NO SE ENCUENTRA CON UNA SESION INICIADA']);;
        }
    }
}
