<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function admin(Request $request)
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
                    'message' => 'Berhasil Log In Admin',
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
            ], 500);
        }
    }

    public function validator(Request $request)
    {
        try {
            $email = $request->email;
            $password = $request->password;

            if ($token = Auth::guard('validator_api')
                ->attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('validator_api')->user();
                $nama = $user->nama;
                $email = $user->email;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In Validator',
                    'id' => $user->id,
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('validator_api')
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
            ], 500);
        }
    }

    public function pakar_sawit(Request $request)
    {
        try {
            $email = $request->email;
            $password = $request->password;

            if ($token = Auth::guard('pakar_api')
                ->attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('pakar_api')->user();
                $nama = $user->nama;
                $email = $user->email;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In Pakar Sawit',
                    'id' => $user->id,
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('pakar_api')
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
            ], 500);
        }
    }

    public function petani(Request $request)
    {
        try {
            $nomor = $request->nomor_telefon;
            $password = $request->password;

            if ($token = Auth::guard('petani_api')
                ->attempt(['nomor_telefon' => $nomor, 'password' => $password])) {
                $user = Auth::guard('petani_api')->user();
                $nama = $user->nama;
                $nomor = $user->nomor_telefon;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In Petani',
                    'id' => $user->id,
                    'nama' => $nama,
                    'nomor_telefon' => $nomor,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('petani_api')
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
            ], 500);
        }
    }
}
