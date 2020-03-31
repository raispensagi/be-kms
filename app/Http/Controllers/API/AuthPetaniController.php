<?php

namespace App\Http\Controllers\API;

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
            $nomor_telefon = $request->nomor_telefon;
            $jk = $request->jenis_kelamin;
            $password = Hash::make($request->password);

//            dd($request);
            // Apabila terdapat nomor telefon yang sama
            if (Petani::where('nomor_telefon', '=', $nomor_telefon)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor Telefon sudah terdaftar.',
                    'Status' => 409
                ], 200);

            } else {
                $user = Petani::create([
                    'nama' => $nama,
                    'nomor_telefon' => $nomor_telefon,
                    'password' => $password,
                    'jenis_kelamin' => $jk
                ]);

                $api_token = $user->createToken('kms-backend')->accessToken;


                return response()->json([
                    'success' => true,
                    'message' => 'Register petani baru berhasil, simpan data petani',
                    'nama' => $nama,
                    'nomor_telefon' => $nomor_telefon,
                    'jenis_kelamin' => $jk,
                    'api_token' => $api_token,
                    'Status' => 201
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'Status' => 500], 200);
        }
    }

    public function login(Request $request)
    {
        try {
            $nt = $request->nomor_telefon;
            $ps = $request->password;
//            dd($request);

            if (Auth::guard('petani')->attempt(['nomor_telefon' => $nt, 'password' => $ps])) {
                $user = Auth::guard('petani')->user();
                $api_token = $user->createToken('kms-backend')->accessToken;
                $nama = $user->nama;
                $nomor_telefon = $user->nomor_telefon;
                $jenis_kelamin = $user->jenis_kelamin;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In',
                    'id' => $user->id,
                    'nama' => $nama,
                    'nomor_telefon' => $nomor_telefon,
                    'jenis_kelamin' => $jenis_kelamin,
                    'api_token' => $api_token,
                    'Status' => 200
                ], 200);

            } else {
                return response()->json(['error' => "Nomor Telefon atau Password salah", "Status" => 400], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'Status' => 500], 200);
        }
    }

    public function logout()
    {
        if (Auth::guard('petani')->check()) {
            Auth::guard('petani')->user()->OauthAcessToken()->delete();
        }
    }
}
