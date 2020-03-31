<?php

namespace App\Http\Controllers\API;

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
            $nt = $request->nomor_telefon;
            $jk = $request->jenis_kelamin;
            $password = Hash::make($request->password);

//            dd($request);
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
                    'nomor_telefon' => $nt,
                    'email' => $email,
                    'password' => $password,
                    'jenis_kelamin' => $jk
                ]);

                $api_token = $user->createToken('kms-backend')->accessToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Register pakar sawit baru berhasil, simpan data pakar sawit',
                    'nama' => $nama,
                    'email' => $email,
                    'nomor_telefon' => $nt,
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
            $em = $request->email;
            $ps = $request->password;
//            dd($request);

            if (Auth::guard('pakar_sawit')->attempt(['email' => $em, 'password' => $ps])) {
                $user = Auth::guard('pakar_sawit')->user();
                $api_token = $user->createToken('kms-backend')->accessToken;
                $nama = $user->nama;
                $email = $user->email;
                $nomor_telefon = $user->nomor_telefon;
                $jenis_kelamin = $user->jenis_kelamin;

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Log In',
                    'id' => $user->id,
                    'nama' => $nama,
                    'email' => $email,
                    'nomor_telefon' => $nomor_telefon,
                    'jenis_kelamin' => $jenis_kelamin,
                    'api_token' => $api_token,
                    'Status' => 200
                ], 200);

            } else {
                return response()->json(['error' => "Email atau Password salah", "Status" => 400], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'Status' => 500], 200);
        }
    }

    public function logout()
    {
        if (Auth::guard('pakar_sawit')->check()) {
            Auth::guard('pakar_sawit')->user()->OauthAcessToken()->delete();
        }
    }
}
