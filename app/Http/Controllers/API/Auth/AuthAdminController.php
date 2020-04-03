<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    public function login(Request $request)
    {
        try {
            $email = $request->email;
            $password = $request->password;

            if ($token = Auth::guard('admin_api')
                ->attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('admin_api')->user();
                $nama = $user->nama;
                $email = $user->email;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In',
                    'id' => $user->id,
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('admin_api')
                            ->factory()->getTTL() * 60,
                    'Status' => 200
                ], 200);

            } else {
                return response()->json([
                    'error' => "Email atau Password salah",
                    "Status" => 400
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 200);
        }
    }

    public function logout()
    {
        try {
            Auth::guard('admin_api')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Log Out',
                'Status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 200);
        }
    }
}
