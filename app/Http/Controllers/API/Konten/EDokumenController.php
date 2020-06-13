<?php

namespace App\Http\Controllers\API\Konten;

use App\EDokumen;
use App\Http\Controllers\Controller;
use App\Konten;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EDokumenController extends Controller
{
    /** Private Function */
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

    private function check($var){
        $validator = Validator::make($var->all(), [
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
            'halaman' => 'required',
            'bahasa' => 'required',
            'deskripsi' => 'required'
        ]);
        return $validator;
    }

    /** Public Function */
    public function draft(Request $request)
    {
        try {
            $validator = $this->check($request);
            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages(),
                    'Status' => 400
                ], 400);
            }
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 409
                ], 409);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $edok = EDokumen::create([
                        'penulis' => $request->penulis,
                        'tahun' => $request->tahun,
                        'penerbit' => $request->penerbit,
                        'halaman' => $request->halaman,
                        'bahasa' => $request->bahasa,
                        'deskripsi' => $request->deskripsi,
                        'file' => 'default.png',
                    ]);

                    if ($request->file('file') != null) {
                        $file = $this->upload_file($request, 'file', 'EDokumen', $edok->id);
                        if ($file != NULL) {
                            $edok->file = $file;
                            $edok->save();
                        }
                    } else {
                        $edok->file = $request->file;
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'EDokumen',
                        'id_tipe' => $edok->id,
                        'is_draft' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'E-Dokumen tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 403
                    ], 403);
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
            $validator = $this->check($request);
            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages(),
                    'Status' => 400
                ], 400);
            }
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 409
                ], 409);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $edok = EDokumen::create([
                        'penulis' => $request->penulis,
                        'tahun' => $request->tahun,
                        'penerbit' => $request->penerbit,
                        'halaman' => $request->halaman,
                        'bahasa' => $request->bahasa,
                        'deskripsi' => $request->deskripsi,
                        'file' => 'default.png',
                    ]);

                    if ($request->file('file') != null) {
                        $file = $this->upload_file($request, 'file', 'EDokumen', $edok->id);
                        if ($file != NULL) {
                            $edok->file = $file;
                            $edok->save();
                        }
                    } else {
                        $edok->file = $request->file;
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'EDokumen',
                        'id_tipe' => $edok->id,
                        'is_draft' => 0,
                        'is_valid' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'E-Dokumen tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 403
                    ], 403);
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
            $validator = $this->check($request);
            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages(),
                    'Status' => 400
                ], 400);
            }
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 409
                ], 409);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $edok = EDokumen::create([
                        'penulis' => $request->penulis,
                        'tahun' => $request->tahun,
                        'penerbit' => $request->penerbit,
                        'halaman' => $request->halaman,
                        'bahasa' => $request->bahasa,
                        'deskripsi' => $request->deskripsi,
                        'file' => 'default.png',
                    ]);

                    if ($request->file('file') != null) {
                        $file = $this->upload_file($request, 'file', 'EDokumen', $edok->id);
                        if ($file != NULL) {
                            $edok->file = $file;
                            $edok->save();
                        }
                    } else {
                        $edok->file = $request->file;
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'EDokumen',
                        'id_tipe' => $edok->id,
                        'is_draft' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'E-Dokumen tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 403
                    ], 403);
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
            $validator = $this->check($request);
            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages(),
                    'Status' => 400
                ], 400);
            }
            if (Konten::where('judul', '=', $request->judul)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Judul sudah ada',
                    'Status' => 409
                ], 409);
            } else {
                // checking user privilage
                $user = Auth::guard('api')->user();

                if ($user->peran == 'pakar_sawit' or $user->peran == 'validator') {
                    $edok = EDokumen::create([
                        'penulis' => $request->penulis,
                        'tahun' => $request->tahun,
                        'penerbit' => $request->penerbit,
                        'halaman' => $request->halaman,
                        'bahasa' => $request->bahasa,
                        'deskripsi' => $request->deskripsi,
                        'file' => 'default.png',
                    ]);

                    if ($request->file('file') != null) {
                        $file = $this->upload_file($request, 'file', 'EDokumen', $edok->id);
                        if ($file != NULL) {
                            $edok->file = $file;
                            $edok->save();
                        }
                    } else {
                        $edok->file = $request->file;
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'EDokumen',
                        'id_tipe' => $edok->id,
                        'is_draft' => 0,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'E-Dokumen tersimpan',
                        'judul' => $request->judul,
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'Status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak bisa membuat konten',
                        'Status' => 403
                    ], 403);
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
