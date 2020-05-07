<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniController extends Controller
{
    //
    public function profil(){
        try {
            $user = Auth::guard('petani_api')->user();

            return response()->json([
                'success' => true,
                'message' => 'Data Petani',
                'id' => $user->id,
                'nama' => $user->nama,
                'nomor_telefon' => $user->nomor_telefon,
                'jenis_kelamin' => $user->jenis_kelamin,
                'Status' => 200
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }
}
