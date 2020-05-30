<?php

namespace App\Http\Controllers\API;

use App\Bookmark;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Notifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    //
    public function add(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();

            $notifikasi = Notifikasi::create([
                'headline' => $request->headline,
                'isi' => $request->isi,
                'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi sudah dibuat',
                'id' => $notifikasi->id,
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

    public function show($id)
    {
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

    public function get_all()
    {
        try {
            $notifikasi = Notifikasi::get();
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

    public function delete($id)
    {
        try {
            $notifikasi = Notifikasi::where('id', $id)->first();
            $notifikasi->delete();

            return response()->json([
                'success' => true,
                'pesan' => 'Notifikasi terhapus',
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
