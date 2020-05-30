<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Konten;
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
}
