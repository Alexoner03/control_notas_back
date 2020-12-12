<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = array_slice(func_get_args(),2);

        foreach ($roles as $rol) {

            if(auth()->user()->hasRole($rol)){
                return $next($request);
            }
        }

        return response()->json([
            'res' => false,
            'message' => 'No tiene permisos para esta función'
        ],401);

    }
}
