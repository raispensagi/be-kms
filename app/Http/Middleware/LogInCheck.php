<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LogInCheck
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
        if (Auth::guard('api')->check()) {
            return $next($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum Log In, silahkan Log In terlebih dahulu!',
                'Status' => 401
            ], 200);
        }
    }
}
