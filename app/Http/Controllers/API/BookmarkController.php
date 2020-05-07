<?php

namespace App\Http\Controllers\API;

use App\Artikel;
use App\Bookmark;
use App\EDokumen;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Penulis;
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
        } elseif ($tipe == "VideoAudio") {
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
        $var = Penulis::where('id', $id)->first();
        $var->makeHidden(['id', 'created_at', 'updated_at']);
        return $var;
    }

    private function get_data($list)
    {
        $var = array();
        foreach ($list as $l) {
            $konten = Konten::where('id', $l->id_konten);
            $isi = $this->get_isi($konten->tipe, $konten->id_tipe);
            $penulis = $this->get_penulis($konten->id_penulis);
            $temp = array(
                'id' => $konten->id,
                'tipe' => $konten->tipe,
                'judul' => $konten->judul,
                'tanggal' => $konten->tanggal,
                'konten' => $isi,
                'penulis' => $penulis
            );
            array_push($var, $temp);
        }
        return $var;
    }

    /** Public function */
    public function add($id)
    {
        try {
            if ($user = Auth::guard('pakar_api')->user()) {
                $var = Bookmark::create([
                    'id_pakar_sawit' => $user->id,
                    'id_konten' => $id,
                ]);
            } elseif ($user = Auth::guard('petani_api')->user()) {
                $var = Bookmark::create([
                    'id_petani' => $user->id,
                    'id_konten' => $id,
                ]);
            }

            $konten = Konten::where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Konten ter-Bookmark',
                'judul' => $konten->judul,
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
            $var = Bookmark::where('id', $id)->first();
            $var->delete();

            return response()->json([
                'success' => true,
                'message' => 'Bookmark terhapus',
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

    public function get_all(){
        try {
            if ($user = Auth::guard('pakar_api')->user()) {
                $list = Bookmark::where('id_pakar_sawit', $user->id)->get();
            } elseif ($user = Auth::guard('petani_api')->user()) {
                $list = Bookmark::where('id_petani', $user->id)->get();
            }

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
