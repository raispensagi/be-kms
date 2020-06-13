<?php

namespace App\Http\Controllers\API;

use App\Artikel;
use App\Bookmark;
use App\EDokumen;
use App\Http\Controllers\Controller;
use App\Konten;
use App\User;
use App\VideoAudio;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /** Private function */
    private function get_isi($tipe, $id)
    {
        if ($tipe == "Artikel") {
            $temp = Artikel::where('id', '=', $id)->first();
            $var = array([
                'isi' => $temp->isi,
                'foto' => $temp->foto,
            ]);
//        }
        } elseif ($tipe == "Video") {
            $temp = VideoAudio::where('id', '=', $id)->first();
            $var = array([
                'isi' => $temp->isi,
                'video_audio' => $temp->video_audio
            ]);
        } elseif ($tipe == "EDokumen") {
            $temp = EDokumen::where('id', '=', $id)->first();
            $var = array([
                'penulis' => $temp->penulis,
                'tahun' => $temp->tahun,
                'penerbit' => $temp->penerbit,
                'halaman' => $temp->halaman,
                'bahasa' => $temp->bahasa,
                'deskripsi' => $temp->deskripsi,
                'file' => $temp->file,
            ]);
        }
        return $var;
    }

    private function get_penulis($id)
    {
        $var = User::where('id', $id)->first();
        $user = array([
            'nama' => $var->nama,
            'peran' => $var->peran,
        ]);
        return $user;
    }

    private function get_data($list)
    {
        $var = array();
        foreach ($list as $l) {
            if ($l->is_hidden != 1){
                $konten = Konten::where('id', $l->konten_id)->first();
                $isi = $this->get_isi($konten->tipe, $konten->id_tipe);
                $penulis = $this->get_penulis($konten->user_id);
                $temp = array(
                    'id' => $l->id,
                    'konten_id' => $konten->id,
                    'tipe' => $konten->tipe,
                    'judul' => $konten->judul,
                    'tanggal' => $konten->tanggal,
                    'konten' => $isi,
                    'penulis' => $penulis
                );
                array_push($var, $temp);
            } else {
                continue;
            }
        }
        return $var;
    }

    /** Public function */
    public function add($id)
    {
        try {
            $user = Auth::guard('api')->user();
            if (Konten::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten tidak ada',
                    'Status' => 404
                ], 404);
            }
            if (Bookmark::where('user_id', $user->id)->where('konten_id', $id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mem-bookmark konten ini',
                    'Status' => 409
                ], 409);
            } else {
                $var = Bookmark::create([
                    'user_id' => $user->id,
                    'konten_id' => $id,
                ]);

                $konten = Konten::where('id', $id)->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Konten ter-Bookmark',
                    'judul' => $konten->judul,
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

    public function delete($id)
    {
        try {
            $user = Auth::guard('api')->user();
//            dd($user->id);
            if (Bookmark::where('user_id', $user->id)->where('konten_id', $id)->exists()){
                $var = Bookmark::where('user_id', $user->id)->where('konten_id', $id)->first();
                $var->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Bookmark terhapus',
                    'Status' => 200
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Bookmark tidak ada',
                    'Status' => 404
                ], 404);
            }


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
            $user = Auth::guard('api')->user();

            $list = $user->bookmark;
            $bookmark = $this->get_data($list);

            return response()->json([
                'success' => true,
                'message' => 'Bookmark Anda',
                'bookmark' => $bookmark,
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
