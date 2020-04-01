<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\PakarSawit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthPakarController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $nama = $request->nama;
            $email = $request->email;
            $nomor = $request->nomor_telefon;
            $kelamin = $request->jenis_kelamin;
            $password = Hash::make($request->password);

            // Apabila terdapat nomor telefon yang sama
            if (PakarSawit::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 200);

            } else {
                $user = PakarSawit::create([
                    'nama' => $nama,
                    'nomor_telefon' => $nomor,
                    'email' => $email,
                    'password' => $password,
                    'jenis_kelamin' => $kelamin,
                    'scope' => 'pakar'
                ]);

                $token = Auth::guard('pakar_api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register pakar sawit baru berhasil, simpan data pakar sawit',
                    'nama' => $nama,
                    'email' => $email,
                    'nomor_telefon' => $nomor,
                    'jenis_kelamin' => $kelamin,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('pakar_api')
                            ->factory()->getTTL() * 60,
                    'Status' => 201
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

    public function login(Request $request)
    {
        try {
            $email = $request->email;
            $password = $request->password;

            if ($token = Auth::guard('pakar_api')
                ->attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::guard('pakar_api')->user();
                $nama = $user->nama;
                $email = $user->email;
                $nomor = $user->nomor_telefon;
                $kelamin = $user->jenis_kelamin;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In',
                    'id' => $user->id,
                    'nama' => $nama,
                    'email' => $email,
                    'nomor_telefon' => $nomor,
                    'jenis_kelamin' => $kelamin,
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
            ], 200);
        }
    }

    public function check_privilage()
    {
        $user = Auth::guard('pakar_api')->user();
        $check_petani = Auth::guard('petani_api')->check();
        $check_pakar = Auth::guard('pakar_api')->check();
        $nama = $user->nama;

        return response()->json([
            'success' => true,
            'message' => 'Data User',
            'id' => $user->id,
            'nama' => $nama,
            'check_petani' => $check_petani,
            'check_pakar' => $check_pakar,
            'Status' => 200
        ], 200);
    }

    public function logout()
    {
        try {
            Auth::guard('pakar_api')->logout();

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
