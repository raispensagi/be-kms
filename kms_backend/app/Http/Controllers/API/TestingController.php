<?php

namespace App\Http\Controllers\API;

use App\Artikel;
use App\Bookmark;
use App\EDokumen;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Notifikasi;
use App\User;
use App\VideoAudio;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function check_request(Request $request) {
        try {
//            dd($request);
            if (empty($request->all())){
                return response()->json([
                    'success' => true,
                    'message' => 'Data kosong',
                    'data' => $request->all(),
                    'Status' => 200
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil Masuk',
                    'data' => $request->all(),
                    'Status' => 200
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

    public function change_video(){
        try {
            if(Konten::where('tipe', 'VideoAudio')->exists()) {
                $var = Konten::where('tipe', 'VideoAudio')->get();
                foreach ($var as $v) {
                    $v->tipe = 'Video';
                    $v->save();
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil diubah',
                    'Status' => 200
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah diubah',
                    'Status' => 403
                ], 403);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

    public function rekap_data(){
        $n_konten = Konten::count();
        $n_bookmark = Bookmark::count();
        $n_user = User::count();
        $n_notif = Notifikasi::count();
        $n_artikel = Artikel::count();
        $n_video = VideoAudio::count();
        $n_edok = EDokumen::count();

        return response()->json([
            'message' => 'Rekap Data',
            'jumlah konten' => $n_konten,
            'jumlah artikel' => $n_artikel,
            'jumlah video' => $n_video,
            'jumlah edokumen' => $n_edok,
            'jumlah user' => $n_user,
            'jumlah bookmark' => $n_bookmark,
            'jumlah notifikasi' => $n_notif,
        ], 200);
    }
}
