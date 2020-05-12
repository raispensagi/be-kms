<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperCheck
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
        $user = Auth::guard()->user();
        if ($user->peran == 'super_admin') {
            return $next($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukanlah Pakar Sawit atau Anda belum Log In, Anda tidak dapat mengakses laman tersebut!',
                'Status' => 401
            ], 200);
        }
    }
}
