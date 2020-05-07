<?php

namespace App\Http\Controllers\API\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\PakarSawit;
use App\Petani;
use \File;
use App\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // fungsi untuk mengunggah foto
    private function upload_foto($request, $value, $peran, $nama)
    {
        // Menyimpan file dan memberi nama sesuai nama yang di upload
        $file = $request->file($value);
        if ($file == NULL) {
            return NULL;
        }

        $char = "$peran" . "_" . "$nama" . "_" . date("d-m-Y") . "_" . date("H-i-s");
        $res = preg_replace("/[^a-zA-Z_0-9]/", "", $char);
        $file_name = $res . "." . $file->getClientOriginalExtension();

        // Upload di folder penyimpanan
        $upload_folder = "img/" . $value;
        $file->move($upload_folder, $file_name);

        return $file_name;
    }

    public function admin(Request $request)
    {
        try {
            $nama = $request->nama;
            $email = $request->email;
            $password = Hash::make($request->password);

            // Apabila terdapat email yang sama
            if (Admin::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = Admin::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                ]);

                $token = Auth::guard('validator_api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register admin baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('pakar_api')
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
            if (Validator::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = Validator::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                ]);

                $foto = $this->upload_foto($request, 'foto', 'Validator', $nama);
                if ($foto != NULL){
                    $user->foto = $foto;
                    $user->save();
                }

                $token = Auth::guard('validator_api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register validator baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('pakar_api')
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
            if (PakarSawit::where('email', '=', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = PakarSawit::create([
                    'nama' => $nama,
                    'email' => $email,
                    'password' => $password,
                ]);

                $foto = $this->upload_foto($request, 'foto', 'PakarSawit', $nama);
//                dd($user);
                if ($foto != NULL){
                    $user->foto = $foto;
                    $user->save();
                }

                $token = Auth::guard('pakar_api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register pakar sawit baru berhasil',
                    'nama' => $nama,
                    'email' => $email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('pakar_api')
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
            $nomor = $request->nomor_telefon;
            $password = Hash::make($request->password);

            // Apabila terdapat nomor telefon yang sama
            if (Petani::where('nomor_telefon', '=', $nomor)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor Telefon sudah terdaftar.',
                    'Status' => 409
                ], 409);

            } else {
                $user = Petani::create([
                    'nama' => $nama,
                    'nomor_telefon' => $nomor,
                    'password' => $password,
                ]);

                $foto = $this->upload_foto($request, 'foto', 'Petani', $nama);
                if ($foto != NULL){
                    $user->foto = $foto;
                    $user->save();
                }

                $token = Auth::guard('petani_api')->login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Register petani baru berhasil',
                    'nama' => $nama,
                    'nomor_telefon' => $nomor,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::guard('petani_api')
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
