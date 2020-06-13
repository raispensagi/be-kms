<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles_allowed)
    {
        $roles = [
            'petani' => 'petani',
            'pakar' => 'pakar_sawit',
            'validator' => 'validator',
            'admin' => 'admin',
            'super' => 'super_admin'
        ];
        $allowed = [];
        foreach ($roles_allowed as $r) {
            if (isset($roles[$r])) {
                $allowed[] = $roles[$r];
            }
        }
        $allowed = array_unique($allowed);

//        dd(Auth::guard('api')->check());
        $user = Auth::guard('api')->user();
        if (Auth::guard('api')->check()) {
            if (in_array($user->peran, $allowed)) {
                return $next($request);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat mengakses laman ini',
                    'Status' => 401
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum Log In',
                'Status' => 401
            ], 401);
        }

    }
}
