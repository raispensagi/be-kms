<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;
use \File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private function check_null($var){

    }

    public function admin(Request $request)
    {
        try {
            $nama = $request->nama;
            $email = $request->email;
            $password = Hash::make($request->password);

            // Apabila terdapat email yang sama
            if (User::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = User::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                    'nomor_telefon' => $request->nomor_telefon,
                    'peran' => 'admin'
                ]);

                $token = Auth::guard('api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register admin baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('api')
                            ->factory()->getTTL() * 60,
                    'Status' => 201
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

    public function super_admin(Request $request)
    {
        try {
            $nama = $request->nama;
            $email = $request->email;
            $password = Hash::make($request->password);

            // Apabila terdapat email yang sama
            if (User::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = User::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                    'nomor_telefon' => $request->nomor_telefon,
                    'peran' => 'super_admin'
                ]);

                $token = Auth::guard('api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register super admin baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('api')
                            ->factory()->getTTL() * 60,
                    'Status' => 201
                ], 201);
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
            $nama = $request->nama;
            $email = $request->email;
            $password = Hash::make($request->password);

            // Apabila terdapat email yang sama
            if (User::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = User::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                    'nomor_telefon' => $request->nomor_telefon,
                    'peran' => 'validator'
                ]);

                $token = Auth::guard('api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register validator baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('api')
                            ->factory()->getTTL() * 60,
                    'Status' => 201
                ], 201);
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
            $nama = $request->nama;
            $email = $request->email;
            $password = Hash::make($request->password);

            // Apabila terdapat email yang sama
            if (User::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = User::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                    'nomor_telefon' => $request->nomor_telefon,
                    'peran' => 'pakar_sawit'
                ]);

                $token = Auth::guard('api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register pakar sawit baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('api')
                            ->factory()->getTTL() * 60,
                    'Status' => 201
                ], 201);
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
            $nama = $request->nama;
            $email = $request->email;
            $password = Hash::make($request->password);

            // Apabila terdapat email yang sama
            if (User::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = User::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                    'nomor_telefon' => $request->nomor_telefon,
                    'peran' => 'petani'
                ]);

                $token = Auth::guard('api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register petani baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('api')
                            ->factory()->getTTL() * 60,
                    'Status' => 201
                ], 201);
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
