<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PetaniCheck
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
        if (Auth::guard('petani_api')->check()) {
            return $next($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukanlah Petani atau Anda belum Log In, Anda tidak dapat mengakses laman tersebut!',
                'Status' => 401
            ], 200);
        }
    }
}
