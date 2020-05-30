<?php

namespace App\Http\Controllers\API;

use App\Artikel;
use App\EDokumen;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Revisi;
use App\User;
use App\VideoAudio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidatorController extends Controller
{
    /** Private Function */
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

    private function get_user($id)
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
            $isi = $this->get_isi($l->tipe, $l->id_tipe);
            $penulis = $this->get_user($l->user_id);
            $temp = array(
                'id' => $l->id,
                'tipe' => $l->tipe,
                'judul' => $l->judul,
                'tanggal' => $l->tanggal,
                'konten' => $isi,
                'penulis' => $penulis
            );
            array_push($var, $temp);
        }
        return $var;
    }

    /** Public Function */
    public function get_konten_not_valid()
    {
        try {
            $list = Konten::where('is_draft', '=', 0)
                ->where('is_valid', '=', 0)->where('is_hidden', '=', 0)->get();

            $konten = $this->get_data($list);

            return response()->json([
                'success' => true,
                'konten' => $konten,
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

    public function get_konten_not_valid_penulis($id) // id = id user
    {
        try {
            $list = Konten::where('user_id', $id)->where('is_draft', '=', 0)
                ->where('is_valid', '=', 0)->where('is_hidden', '=', 0)->get();

            $konten = $this->get_data($list);

            return response()->json([
                'success' => true,
                'konten' => $konten,
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

    public function validasi($id) {
        try {
            $user = Auth::guard('api')->user();
            $konten = Konten::where("id", $id)->first();
            if ($konten->user_id == $user->id) {
                return response()->json([
                    'success' => true,
                    'message' => "Anda tidak bisa memvalidasi konten Anda sendiri",
                    'Status' => 403
                ], 403);
            }
            if ($konten->is_valid == 0) {
                $konten->is_valid = 1;
                $konten->save();

//                $konten = $this->get_data($konten);
                return response()->json([
                    'success' => true,
                    'konten' => $konten,
                    'Status' => 200
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten sudah valid',
                    'Status' => 500
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

    public function revisi(Request $request, $id) {
        try {
            $user = Auth::guard('api')->user();
            $konten = Konten::where("id", $id)->first();
            if ($konten->user_id == $user->id) {
                return response()->json([
                    'success' => true,
                    'message' => "Anda tidak bisa memvalidasi konten Anda sendiri",
                    'Status' => 403
                ], 403);
            }
            if ($konten->is_valid == 1) {
                return response()->json([
                    'success' => true,
                    'message' => "Konten sudah Valid",
                    'Status' => 403
                ], 403);
            } elseif ($konten->is_draft == 1) {
                return response()->json([
                    'success' => true,
                    'message' => "Konten masih dalam draft",
                    'Status' => 403
                ], 403);
            } else {
                $konten->is_draft = 1;
                $konten->save();

                $revisi = Revisi::create([
                    'komentar' => $request->komentar,
                    'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                    'user_id' => $user->id,
                    'konten_id' => $konten->id
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Konten telah direvisi",
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
}
