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

//    public function edit_draft(Request $request, $id)
//    {
//        try {
//            $user = $this->check_user();
//            if (Penulis::where('nama', '=', $user[0]->nama)->exists()) {
//
//                $konten = Konten::where('id', '=', $id)->first();
////                dd($request);
//                if ($konten->is_draft == 0) {
//                    return response()->json([
//                        'success' => false,
//                        'message' => 'Anda tidak bisa mengubah konten yang sudah di-post',
//                        'Status' => 500
//                    ], 500);
//                }
//
//                if (Konten::where('judul', '=', $request->judul)->where('id', '!=', $id)->exists()) {
//                    return response()->json([
//                        'success' => false,
//                        'message' => 'Judul sudah ada',
//                        'Status' => 500
//                    ], 500);
//                }
//                $konten->kategori = $request->kategori;
//                $konten->sub_kategori = $request->sub_kategori;
//                $konten->judul = $request->judul;
//                $konten->tanggal = Carbon::now()->format('d F Y H:i:s');
//                $konten->save();
//
//                $artikel = Artikel::where('id', '=', $konten->id_tipe)->first();
//                $artikel->isi = $request->isi;
//                $foto = $this->upload_foto($request, 'foto', 'Artikel', $artikel->id);
//                if ($foto != NULL) {
//                    $artikel->foto = $foto;
//                }
//                $artikel->save();
//
//                return response()->json([
//                    'success' => true,
//                    'message' => 'Artikel telah diperbaharui',
//                    'judul' => $request->judul,
//                    'kategori' => $request->kategori,
//                    'sub_kategori' => $request->sub_kategori,
//                    'Status' => 201
//                ], 201);
//            } else {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Maaf, Anda tidak bisa mengubah Konten orang lain!',
//                    'Status' => 500
//                ], 500);
//            };
//        } catch (\Exception $e) {
//            return response()->json([
//                'success' => false,
//                'message' => $e->getMessage(),
//                'Status' => 500
//            ], 500);
//        }
//    }

}
