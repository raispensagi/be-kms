<?php

namespace App\Http\Controllers\API\Konten;

use App\Artikel;
use App\Bookmark;
use App\EDokumen;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Notifikasi;
use App\Revisi;
use App\Riwayat;
use App\User;
use App\VideoAudio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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
        $user = Auth::guard('api')->user();
        $var = array();
        foreach ($list as $l) {
            $isi = $this->get_isi($l->tipe, $l->id_tipe);
            $penulis = $this->get_user($l->user_id);
            if (Bookmark::where('user_id', $user->id)->where('konten_id', $l->id)->exists()) {
                $bookmarked = true;
            } else {
                $bookmarked = false;
            }
            if (Revisi::where('konten_id', $l->id)->exists()) {
                $rev = Revisi::where('konten_id', $l->id)->get();
                $revisi = array();
                foreach ($rev as $r) {
                    $temp = array(
                        'id' => $r->id,
                        'komentar' => $r->komentar,
                        'tanggal' => $r->tanggal,
                        'validator' => $r->user->nama,
                    );
                    array_push($revisi, $temp);
                }
                $temp = array(
                    'id' => $l->id,
                    'tipe' => $l->tipe,
                    'judul' => $l->judul,
                    'kategori' => $l->kategori,
                    'sub_kategori' => $l->sub_kategori,
                    'tanggal' => $l->tanggal,
                    'konten' => $isi,
                    'penulis' => $penulis,
                    'revisi' => $revisi,
                    'bookmark' => $bookmarked
                );
            } else {
                $temp = array(
                    'id' => $l->id,
                    'tipe' => $l->tipe,
                    'judul' => $l->judul,
                    'kategori' => $l->kategori,
                    'sub_kategori' => $l->sub_kategori,
                    'tanggal' => $l->tanggal,
                    'konten' => $isi,
                    'penulis' => $penulis,
                    'bookmark' => $bookmarked
                );
            }
            array_push($var, $temp);
        }
        return $var;
    }

    private function edit_konten($tipe, $id, $request)
    {
        if ($tipe == "Artikel") {
            $var = Artikel::where('id', '=', $id)->first();
            if ($request->isi != null) {
                $var->isi = $request->isi;
            }
            $foto = $this->upload_foto($request, 'foto', 'Artikel', $var->id);
            if ($foto != NULL) {
                $path = 'img/foto/' . $var->foto;
                File::delete($path);
                $var->foto = $foto;
            }
            $var->save();
//        }
        } elseif ($tipe == "Video") {
            $var = VideoAudio::where('id', '=', $id)->first();
            if ($request->isi != null) {
                $var->isi = $request->isi;
            }
            if ($request->file('video_audio') != null) {
                $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $var->id);
                if ($file != NULL) {
                    $path = 'file/video_audio/' . $var->video_audio;
                    File::delete($path);
                    $var->video_audio = $file;
                }
            } else {
                $var->video_audio = $request->video_audio;
            }
            $var->save();
        } elseif ($tipe == "EDokumen") {
            $var = EDokumen::where('id', '=', $id)->first();
            $var->penulis = $request->penulis;
            $var->tahun = $request->tahun;
            $var->penerbit = $request->penerbit;
            $var->halaman = $request->halaman;
            $var->bahasa = $request->bahasa;
            $var->deskripsi = $request->deskripsi;
            if ($request->file('file') != null) {
                $file = $this->upload_file($request, 'file', 'EDokumen', $var->id);
                if ($file != NULL) {
                    $path = 'file/file/' . $var->file;
                    File::delete($path);
                    $var->file = $file;
                }
            } else {
                $var->file = $request->file;
            }
            $var->save();

        }
    }

    private function riwayat($id)
    {
        $user = Auth::guard('api')->user();
        if (Riwayat::where('user_id', $user->id)->count() <= 10) {
            if (Riwayat::where('user_id', $user->id)->where('konten_id', $id)->exists()) {
                $temp = Riwayat::where('user_id', $user->id)->where('konten_id', $id)->first();
                $temp->delete();
            }
            $var = Riwayat::create([
                'user_id' => $user->id,
                'konten_id' => $id,
            ]);
        } else {
            if (Riwayat::where('user_id', $user->id)->where('konten_id', $id)->exists()) {
                $temp = Riwayat::where('user_id', $user->id)->where('konten_id', $id)->first();
                $temp->delete();
            } else {
                $temp = Riwayat::where('user_id', $user->id)->first();
                $temp->delete();
            }
            $var = Riwayat::create([
                'user_id' => $user->id,
                'konten_id' => $id,
            ]);
        }

    }

    /** Public Function */
    public function get_all()
    {
        try {
            $list = Konten::get();

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

            $list = Konten::where('user_id', $id)->where('is_draft', '=', 0)
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

    public function get_all_artikel()
    {
        try {
            $list = Konten::where('is_draft', '=', 0)
                ->where('is_valid', '=', 1)->where('is_hidden', '=', 0)
                ->where('tipe', '=', 'Artikel')->get();

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

    public function get_all_video_audio()
    {
        try {
            $list = Konten::where('is_draft', '=', 0)
                ->where('is_valid', '=', 1)->where('is_hidden', '=', 0)
                ->where('tipe', '=', 'Video')->get();

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

    public function get_all_edokumen()
    {
        try {
            $list = Konten::where('is_draft', '=', 0)
                ->where('is_valid', '=', 1)->where('is_hidden', '=', 0)
                ->where('tipe', '=', 'EDokumen')->get();

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

    public function get_all_post()
    {
        try {
            $list = Konten::where('is_draft', 0)
                ->where('is_valid', 1)->where('is_hidden', 0)->get();
            $konten = $this->get_data($list);
            return response()->json([
                'success' => true,  'konten' => $konten, 'Status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,  'message' => $e->getMessage(), 'Status' => 500
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            if (Konten::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten tidak ada',
                    'Status' => 404
                ], 404);
            }
            $var = Konten::where('id', $id)->first();
            $user = Auth::guard('api')->user();
            if ($user->peran == 'petani' or $user->peran == 'pakar_sawit') {
                $this->riwayat($var->id);
            }
            if (Bookmark::where('user_id', $user->id)->where('konten_id', $id)->exists()) {
                $bookmarked = true;
            } else {
                $bookmarked = false;
            }
            $isi = $this->get_isi($var->tipe, $var->id_tipe);
            $penulis = $this->get_user($var->user_id);
            $konten = array([
                'id' => $id,
                'tipe' => $var->tipe,
                'judul' => $var->judul,
                'tanggal' => $var->tanggal,
                'konten' => $isi,
                'penulis' => $penulis,
                'bookmark' => $bookmarked
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
            $validator = Validator::make($request->all(), [
                'kategori' => 'required|string',
            ]);
            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages(),
                    'Status' => 400
                ], 400);
            }
            $list = Konten::where('kategori', '=', $request->kategori)
                ->where('sub_kategori', '=', $request->sub_kategori)
                ->where('is_draft', '=', 0)->where('is_valid', '=', 1)
                ->where('is_hidden', '=', 0)->get();

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
            $validator = Validator::make($request->all(), [
                'keyword' => 'required',
            ]);
            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages(),
                    'Status' => 400
                ], 400);
            }
            $keyword = $request->keyword;

            $list = Konten::where(function ($query) use ($keyword) {
                $query->where('kategori', 'like', '%' . $keyword . '%')
                    ->orWhere('sub_kategori', 'like', '%' . $keyword . '%')
                    ->orWhere('judul', 'like', '%' . $keyword . '%');
            })->where('is_draft', '=', 0)->where('is_valid', '=', 1)
                ->where('is_hidden', '=', 0)->get();

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
            $user = Auth::guard('api')->user();
            if (Konten::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten tidak ada',
                    'Status' => 404
                ], 404);
            }
            $konten = Konten::where('id', '=', $id)->first();
            if ($user->id == $konten->user_id) {
                if ($konten->is_draft == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa mengubah konten yang sudah di-post',
                        'Status' => 403
                    ], 403);
                }

                if (Konten::where('judul', '=', $request->judul)->where('id', '!=', $id)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Judul sudah ada',
                        'Status' => 409
                    ], 409);
                }

                if ($request->judul != null) {
                    $konten->judul = $request->judul;
                }
                if ($request->kategori != null) {
                    $konten->kategori = $request->kategori;
                }
                if ($request->sub_kategori != null) {
                    $konten->sub_kategori = $request->sub_kategori;
                }
                $konten->tanggal = Carbon::now()->format('d F Y H:i:s');
                $konten->save();

                $this->edit_konten($konten->tipe, $konten->id_tipe, $request);

                return response()->json([
                    'success' => true,
                    'message' => 'Konten telah diperbaharui',
                    'judul' => $konten->judul,
                    'kategori' => $konten->kategori,
                    'sub_kategori' => $konten->sub_kategori,
                    'Status' => 200
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, Anda tidak bisa mengubah Konten orang lain!',
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

    public function draft_to_post($id)
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
            $konten = Konten::where('id', '=', $id)->first();
            if ($user->id == $konten->user_id) {
                $konten->is_draft = 0;
                $konten->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Konten telah di-post',
                    'judul' => $konten->judul,
                    'kategori' => $konten->kategori,
                    'sub_kategori' => $konten->sub_kategori,
                    'Status' => 200
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, Anda tidak bisa mengubah Konten orang lain!',
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

    public function get_my_draft()
    {
        try {
            $id = Auth::guard('api')->user()->id;
            $list = Konten::where('is_draft', '=', 1)
                ->where('is_valid', '=', 0)->where('is_hidden', '=', 0)
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

    public function get_my_post()
    {
        try {
            $id = Auth::guard('api')->user()->id;
            $list = Konten::where('is_draft', '=', 0)->where('is_hidden', '=', 0)
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

    public function get_revisi()
    {
        try {
            $user = Auth::guard('api')->user();

            $list = Konten::where('user_id', $user->id)->where('is_draft', 1)
                ->has('revisi')->get();

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

    public function hide_post($id)
    {
        try {
            if (Konten::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten tidak ada',
                    'Status' => 404
                ], 404);
            }
            $konten = Konten::where("id", $id)->first();
            if ($konten->is_hidden == 1) {
                return response()->json([
                    'success' => true,
                    'message' => "Konten sudah tersembunyi",
                    'Status' => 403
                ], 403);
            } elseif ($konten->is_draft == 1) {
                return response()->json([
                    'success' => true,
                    'message' => "Konten belum ter-post",
                    'Status' => 403
                ], 403);
            } else {
                $konten->is_hidden = 1;
                $konten->save();
                return response()->json([
                    'success' => true,
                    'message' => "Konten telah disembunyikan",
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

    public function unhide_post($id)
    {
        try {
            if (Konten::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten tidak ada',
                    'Status' => 404
                ], 404);
            }
            $konten = Konten::where("id", $id)->first();
            if ($konten->is_hidden == 0) {
                return response()->json([
                    'success' => true,
                    'message' => "Konten belum disembunyikan",
                    'Status' => 403
                ], 403);
            } elseif ($konten->is_draft == 1) {
                return response()->json([
                    'success' => true,
                    'message' => "Konten belum ter-post",
                    'Status' => 403
                ], 403);
            } else {
                $konten->is_hidden = 0;
                $konten->save();
                return response()->json([
                    'success' => true,
                    'message' => "Konten telah dimunculkan",
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

    public function delete($id)
    {
        try {
            if (Konten::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konten tidak ada',
                    'Status' => 404
                ], 404);
            }
            $konten = Konten::where("id", $id)->first();
            if ($konten->tipe == "Artikel") {
                $var = Artikel::where('id', '=', $id)->first();
                if ($var->foto != 'default.png') {
                    $path = 'img/foto/' . $var->foto;
                    File::delete($path);
                }
            } elseif ($konten->tipe == "Video") {
                $var = VideoAudio::where('id', '=', $id)->first();
                if ($var->video_audio != 'default.png') {
                    $path = 'file/video_audio/' . $var->video_audio;
                    File::delete($path);
                }
            } elseif ($konten->tipe == "EDokumen") {
                $var = Artikel::where('id', '=', $id)->first();
                if ($var->file != 'default.png') {
                    $path = 'file/file/' . $var->file;
                    File::delete($path);
                }
            }
            if (Bookmark::where('konten_id', $id)->exists()) {
                $bookmark = Bookmark::where('konten_id', $id)->get();
                foreach ($bookmark as $b) {
                    $b->delete();
                }
            }
            if (Riwayat::where('konten_id', $id)->exists()) {
                $riwayat = Riwayat::where('konten_id', $id)->get();
                foreach ($riwayat as $r) {
                    $r->delete();
                }
            }

            $var->delete();
            $konten->delete();

            return response()->json([
                'success' => true,
                'message' => "Konten terhapus",
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
