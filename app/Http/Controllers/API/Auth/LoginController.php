<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);
            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages(),
                    'Status' => 400
                ], 400);
            }
            $email = $request->email;
            $password = $request->password;

            if ($token = Auth::guard('api')
                ->attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('api')->user();
                $nama = $user->nama;
                $email = $user->email;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil login ' . $user->peran,
                    'id' => $user->id,
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('api')
                            ->factory()->getTTL() * 60,
                    'Status' => 200
                ], 200);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Email atau Password salah",
                    "Status" => 401
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

}
