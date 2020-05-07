<?php

namespace App\Http\Controllers\API;

use App\Bookmark;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    //
    public function add(Request $request)
    {
        try {
            if ($user = Auth::guard('pakar_api')->user()) {
                $nama = $user->nama;
            } elseif ($user = Auth::guard('validator_api')->user()) {
                $nama = $user->nama;
            } elseif ($user = Auth::guard('admin_api')->user()) {
                $nama = $user->nama;
            }

            $notifikasi = Notifikasi::create([
                'headline' => $request->headline,
                'isi' => $request->isi,
                'penulis' => $nama
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi sudah dibuat',
                'headline' => $request->headline,
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

    public function show($id){
        try {
            $notifikasi = Notifikasi::where('id', $id)->first();
            $notifikasi->makeHidden(['created_at', 'updated_at']);

            return response()->json([
                'success' => true,
                'notifikasi' => $notifikasi,
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

    public function delete($id){
        try {
            $notifikasi = Notifikasi::where('id', $id)->first();
            $notifikasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi sudah terhapus',
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
