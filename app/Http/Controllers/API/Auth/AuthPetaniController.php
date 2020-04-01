<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthPetaniController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $nama = $request->nama;
            $nomor = $request->nomor_telefon;
            $kelamin = $request->jenis_kelamin;
            $password = Hash::make($request->password);

            // Apabila terdapat nomor telefon yang sama
            if (Petani::where('nomor_telefon', '=', $nomor)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor Telefon sudah terdaftar.',
                    'Status' => 409
                ], 200);

            } else {
                $user = Petani::create([
                    'nama' => $nama,
                    'nomor_telefon' => $nomor,
                    'password' => $password,
                    'jenis_kelamin' => $kelamin,
                    'scope' => 'pakar'
                ]);

                $token = Auth::guard('petani_api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register petani baru berhasil, simpan data petani',
                    'nama' => $nama,
                    'nomor_telefon' => $nomor,
                    'jenis_kelamin' => $kelamin,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('petani_api')
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
            $nomor = $request->nomor_telefon;
            $password = $request->password;
//            dd($request);

            if ($token = Auth::guard('petani_api')
                ->attempt(['nomor_telefon' => $nomor, 'password' => $password])) {
                $user = Auth::guard('petani_api')->user();
                $nama = $user->nama;
                $nomor = $user->nomor_telefon;
                $kelamin = $user->jenis_kelamin;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In',
                    'id' => $user->id,
                    'nama' => $nama,
                    'nomor_telefon' => $nomor,
                    'jenis_kelamin' => $kelamin,
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
            ], 200);
        }
    }

    public function check_privilage()
    {
        $user = Auth::guard('petani_api')->user();
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
            Auth::guard('petani_api')->logout();

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
