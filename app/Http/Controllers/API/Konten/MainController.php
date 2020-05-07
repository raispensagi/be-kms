<?php

namespace App\Http\Controllers\API\Konten;

use App\Artikel;
use App\Bookmark;
use App\EDokumen;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Notifikasi;
use App\Penulis;
use App\Riwayat;
use App\VideoAudio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /** Private Function */
    private function upload_foto($request, $value, $tipe, $id)
    {
        // Menyimpan file dan memberi nama sesuai nama yang di upload
        $file = $request->file($value);
        if ($file == NULL) {
            return NULL;
        }

        $char = "$tipe" . "_" . "$id" . "_" . date("d-m-Y") . "_" . date("H-i-s");
        $res = preg_replace("/[^a-zA-Z_0-9]/", "", $char);
        $file_name = $res . "." . $file->getClientOriginalExtension();

        // Upload di folder penyimpanan
        $upload_folder = "img/" . $value;
        $file->move($upload_folder, $file_name);

        return $file_name;
    }

    private function upload_file($request, $value, $tipe, $id)
    {
        // Menyimpan file dan memberi nama sesuai nama yang di upload
        $file = $request->file($value);
        if ($file == NULL) {
            return NULL;
        }

        $char = "$tipe" . "_" . "$id" . "_" . date("d-m-Y") . "_" . date("H-i-s");
        $res = preg_replace("/[^a-zA-Z_0-9]/", "", $char);
        $file_name = $res . "." . $file->getClientOriginalExtension();

        // Upload di folder penyimpanan
        $upload_folder = "file/" . $value;
        $file->move($upload_folder, $file_name);

        return $file_name;
    }

    private function check_user()
    {
        if (Auth::guard('pakar_api')->check()) {
            $user = Auth::guard('pakar_api')->user();
            $peran = 'Pakar';
        } elseif (Auth::guard('validator_api')->check()) {
            $user = Auth::guard('validator_api')->user();
            $peran = 'Validator';
        }
        $data = [$user, $peran];

        return $data;
    }

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
            $isi = $this->get_isi($l->tipe, $l->id_tipe);
            $penulis = $this->get_penulis($l->id_penulis);
//            $penulis = $l->penulis();
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

    private function edit_konten($tipe, $id, $request)
    {
        if ($tipe == "Artikel") {
            $var = Artikel::where('id', '=', $id)->first();
            $var->isi = $request->isi;
            $foto = $this->upload_foto($request, 'foto', 'Artikel', $var->id);
            if ($foto != NULL) {
                $var->foto = $foto;
            }
            $var->save();
//        }
        } elseif ($tipe == "VideoAudio") {
            $var = Artikel::where('id', '=', $id)->first();
            $var->isi = $request->isi;
            $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $var->id);
            if ($file != NULL) {
                $var->video_audio = $file;
            }
            $var->save();
        } elseif ($tipe == "EDokumen") {
            $var = Artikel::where('id', '=', $id)->first();
            $var->penulis = $request->penulis;
            $var->tahun = $request->tahun;
            $var->penerbit = $request->penerbit;
            $var->halaman = $request->halaman;
            $var->bahasa = $request->bahasa;
            $var->deskripsi = $request->deskripsi;
            $file = $this->upload_file($request, 'file', 'EDokumen', $var->id);
            if ($file != NULL) {
                $var->file = $file;
            }
            $var->save();
        }
    }

    private function riwayat($id)
    {
        if ($user = Auth::guard('pakar_api')->user()) {
            if(Riwayat::where('id_pakar_sawit', $user->id)->count() <= 10) {
                if (Riwayat::where('id_pakar_sawit', $user->id)->where('id_konten', $id)->exists()){
                    $temp = Riwayat::where('id_pakar_sawit', $user->id)->where('id_konten', $id);
                    $temp->delete();
                }
                $var = Riwayat::create([
                    'id_pakar_sawit' => $user->id,
                    'id_konten' => $id,
                ]);
            } else {
                if (Riwayat::where('id_pakar_sawit', $user->id)->where('id_konten', $id)->exists()){
                    $temp = Riwayat::where('id_pakar_sawit', $user->id)->where('id_konten', $id);
                    $temp->delete();
                } else {
                    $temp = Riwayat::where('id_pakar_sawit', $user->id)->first();
                    $temp->delete();
                }
                $var = Riwayat::create([
                    'id_pakar_sawit' => $user->id,
                    'id_konten' => $id,
                ]);
            }
        } elseif ($user = Auth::guard('petani_api')->user()) {
            if(Riwayat::where('id_petani', $user->id)->count() < 10) {
                if (Riwayat::where('id_petani', $user->id)->where('id_konten', $id)->exists()){
                    $temp = Riwayat::where('id_petani', $user->id)->where('id_konten', $id);
                    $temp->delete();
                }
                $var = Riwayat::create([
                    'id_petani' => $user->id,
                    'id_konten' => $id,
                ]);
            } else {
                if (Riwayat::where('id_petani', $user->id)->where('id_konten', $id)->exists()){
                    $temp = Riwayat::where('id_petani', $user->id)->where('id_konten', $id);
                    $temp->delete();
                } else {
                    $temp = Riwayat::where('id_petani', $user->id)->first();
                    $temp->delete();
                }
                $var = Riwayat::create([
                    'id_petani' => $user->id,
                    'id_konten' => $id,
                ]);
            }
        }
    }

    /** Public Function */
    public function get_all()
    {
        try {
            $list = Konten::where('is_draft', '=', 0)
                ->where('is_valid', '=', 1)->where('is_hidden', '=', 0)
                ->get();

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

    public function get_konten_penulis($id)
    {
        try {
//            $penulis = Penulis::where('id', $id)->first();
            $list = Konten::where('id_penulis', $id)->where('is_draft', '=', 0)
                ->where('is_valid', '=', 1)->where('is_hidden', '=', 0)->get();

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

    public function show($id)
    {
        try {
            $var = Konten::where('id', $id)->first();
            if (Auth::guard('petani_api')->check() or Auth::guard('pakar_api')->check()) {
                $this->riwayat($var->id);
            }
            $isi = $this->get_isi($var->tipe, $var->id_tipe);
            $penulis = $this->get_penulis($var->id_penulis);
            $konten = array([
                'id' => $id,
                'tipe' => $var->tipe,
                'judul' => $var->judul,
                'tanggal' => $var->tanggal,
                'konten' => $isi,
                'penulis' => $penulis
            ]);
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

    public function search_kategori(Request $request)
    {
        try {
            $list = Konten::where('kategori', '=', $request->kategori)
                ->where('sub_kategori', '=', $request->sub_kategori)
                ->where('is_draft', '=', 0)->where('is_valid', '=', 1)
                ->where('is_hidden', '=', 0)->all();

            $konten = $this->get_data($list);

            return response()->json([
                'success' => true,
                'hasil' => $konten,
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

    public function search(Request $request)
    {
        try {
            $keyword = $request->keyword;

            $list = Konten::where(function ($query) use ($keyword) {
                $query->where('kategori', 'like', '%' . $keyword . '%')
                    ->orWhere('sub_kategori', 'like', '%' . $keyword . '%')
                    ->orWhere('judul', 'like', '%' . $keyword . '%');
            })->where('is_draft', '=', 0)->where('is_valid', '=', 1)
                ->where('is_hidden', '=', 0)->all();

            $konten = $this->get_data($list);

            return response()->json([
                'success' => true,
                'hasil' => $konten,
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

    public function edit_draft(Request $request, $id)
    {
        try {
            $user = $this->check_user();
            if (Penulis::where('nama', '=', $user[0]->nama)->exists()) {

                $konten = Konten::where('id', '=', $id)->first();
                if ($konten->is_draft == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa mengubah konten yang sudah di-post',
                        'Status' => 500
                    ], 500);
                }

                if (Konten::where('judul', '=', $request->judul)->where('id', '!=', $id)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Judul sudah ada',
                        'Status' => 500
                    ], 500);
                }
                $konten->kategori = $request->kategori;
                $konten->sub_kategori = $request->sub_kategori;
                $konten->judul = $request->judul;
                $konten->tanggal = Carbon::now()->format('d F Y H:i:s');
                $konten->save();

                $this->edit_konten($konten->tipe, $konten->id_tipe, $request);

                return response()->json([
                    'success' => true,
                    'message' => 'Konten telah diperbaharui',
                    'judul' => $request->judul,
                    'kategori' => $request->kategori,
                    'sub_kategori' => $request->sub_kategori,
                    'Status' => 201
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, Anda tidak bisa mengubah Konten orang lain!',
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

    public function draft_to_post($id)
    {
        try {
            $user = $this->check_user();
            if (Penulis::where('nama', '=', $user[0]->nama)->exists()) {
                $konten = Konten::where('id', '=', $id)->first();
                $konten->is_draft = 0;
                $konten->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Konten telah di-post',
                    'judul' => $konten->judul,
                    'kategori' => $konten->kategori,
                    'sub_kategori' => $konten->sub_kategori,
                    'Status' => 201
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, Anda tidak bisa mengubah Konten orang lain!',
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
}
