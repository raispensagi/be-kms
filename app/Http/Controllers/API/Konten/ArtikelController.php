<?php

namespace App\Http\Controllers\API\Konten;

use App\Artikel;
use App\Http\Controllers\Controller;
use App\Konten;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
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

    /** Public Function */
    public function draft(Request $request)
    {
        try {
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 500
                ], 500);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $artikel = Artikel::create([
                        'isi' => $request->isi,
                        'foto' => 'default.png',
                    ]);

                    $foto = $this->upload_foto($request, 'foto', 'Artikel', $artikel->id);
                    if ($foto != NULL) {
                        $artikel->foto = $foto;
                        $artikel->save();
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Artikel',
                        'id_tipe' => $artikel->id,
                        'is_draft' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Artikel tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 500
                    ], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

    public function post(Request $request)
    {
        try {
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 500
                ], 500);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $artikel = Artikel::create([
                        'isi' => $request->isi,
                        'foto' => 'default.png',
                    ]);

                    $foto = $this->upload_foto($request, 'foto', 'Artikel', $artikel->id);
                    if ($foto != NULL) {
                        $artikel->foto = $foto;
                        $artikel->save();
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Artikel',
                        'id_tipe' => $artikel->id,
                        'is_draft' => 0,
                        'is_valid' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Artikel tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 500
                    ], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

    /** Apabila ada aplikasi WEB, bedanya untuk web harus divalidasi terlebih dahulu */
    public function draft_web(Request $request)
    {
        try {
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 500
                ], 500);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $artikel = Artikel::create([
                        'isi' => $request->isi,
                        'foto' => 'default.png',
                    ]);

                    $foto = $this->upload_foto($request, 'foto', 'Artikel', $artikel->id);
                    if ($foto != NULL) {
                        $artikel->foto = $foto;
                        $artikel->save();
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Artikel',
                        'id_tipe' => $artikel->id,
                        'is_draft' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Artikel tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 500
                    ], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

    public function post_web(Request $request)
    {
        try {
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 500
                ], 500);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $artikel = Artikel::create([
                        'isi' => $request->isi,
                        'foto' => 'default.png',
                    ]);

                    $foto = $this->upload_foto($request, 'foto', 'Artikel', $artikel->id);
                    if ($foto != NULL) {
                        $artikel->foto = $foto;
                        $artikel->save();
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Artikel',
                        'id_tipe' => $artikel->id,
                        'is_draft' => 0,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Artikel tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 500
                    ], 500);
                }
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
