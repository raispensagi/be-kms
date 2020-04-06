<?php

namespace App\Http\Controllers\API;

use App\Artikel;
use App\Http\Controllers\Controller;
use App\PakarSawit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    //
    public function draft(Request $request)
    {
        try {
            $judul = $request->judul;
            $konten = $request->konten;
            $tanggal = Carbon::now()->format('d F Y H:i:s');

            $user = Auth::guard('pakar_api')->user();
            $id = $user->id;

            $var = Artikel::create([
                'judul' => $judul,
                'konten' => $konten,
                'tanggal' => $tanggal,
                'draft' => 1,
                'pakar_sawit_id' => $id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Artikel tersimpan dalam Draft',
                'artikel_id' => $var->id,
                'user_id' => $user->id,
                'nama' => $user->nama,
                'tanggal' => $tanggal,
                'Status' => 201
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 200);
        }
    }

    public function post(Request $request)
    {
        try {
            $judul = $request->judul;
            $konten = $request->konten;
            $tanggal = Carbon::now()->format('d F Y H:i:s');

            $user = Auth::guard('pakar_api')->user();
            $id = $user->id;

            $var = Artikel::create([
                'judul' => $judul,
                'konten' => $konten,
                'tanggal' => $tanggal,
                'posted' => 1,
                'pakar_sawit_id' => $id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Artikel terunggah, menunggu validasi',
                'artikel_id' => $var->id,
                'user_id' => $user->id,
                'nama' => $user->nama,
                'tanggal' => $tanggal,
                'Status' => 201
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 200);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $artikel = Artikel::find($id);
            $tanggal = Carbon::now()->format('d F Y H:i:s');

            $user = Auth::guard('pakar_api')->user();
            $user_id = $user->id;

            if ($user_id != $artikel->pakar_sawit_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat mengubah Artikel orang lain!',
                    'Status' => 403
                ], 403);
            }

            $artikel->judul = $request->judul;
            $artikel->konten = $request->konten;
            $artikel->tanggal = $tanggal;
            $artikel->save();

            return response()->json([
                'success' => true,
                'message' => 'Artikel telah diubah',
                'artikel_id' => $artikel->id,
                'tanggal' => $tanggal,
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

    public function draft_to_post($id)
    {
        try {
            $artikel = Artikel::find($id);
            $tanggal = Carbon::now()->format('d F Y H:i:s');

            $user = Auth::guard('pakar_api')->user();
            $user_id = $user->id;

            if ($user_id != $artikel->pakar_sawit_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat mengubah Artikel orang lain!',
                    'Status' => 403
                ], 403);
            }

            $artikel->tanggal = $tanggal;
            $artikel->draft = 0;
            $artikel->posted = 1;
            $artikel->save();

            return response()->json([
                'success' => true,
                'message' => 'Artikel telah diunggah, menunggu validasi',
                'artikel_id' => $artikel->id,
                'judul' => $artikel->judul,
                'tanggal' => $tanggal,
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

    public function show_pakar()
    {
        try {
            $user = Auth::guard('pakar_api')->user();

            $var = $user->artikel()->get();
            $artikel = [];

            foreach ($var as $v) {
                $id = $v->id;
                $judul = $v->judul;
                $tanggal = $v->tanggal;
                $konten = $v->konten;
                if ($v->draft == 0) {
                    $draft = 'Tidak';
                } else {
                    $draft = 'Ya';
                }
                if ($v->valid == 0) {
                    $valid = 'Tidak';
                } else {
                    $valid = 'Ya';
                }
                if ($v->posted == 0) {
                    $posted = 'Tidak';
                } else {
                    $posted = 'Ya';
                }
                if ($v->hidden == 0) {
                    $hidden = 'Tidak';
                } else {
                    $hidden = 'Ya';
                }

                $temp = [
                    'id' => $id,
                    'judul' => $judul,
                    'tanggal' => $tanggal,
                    'konten' => $konten,
                    'draft' => $draft,
                    'valid' => $valid,
                    'posted' => $posted,
                    'hidden' => $hidden,
                ];
                array_push($artikel, $temp);
            }

            return response()->json([
                'success' => true,
                'id' => $user->id,
                'nama' => $user->nama,
                'artikel' => $artikel,
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

    public function show_petani()
    {
        try {
            $user = Auth::guard('petani_api')->user();

            $var = Artikel::where('hidden','!=',1)->get();
            $artikel = [];

            foreach ($var as $v) {
                $id = $v->id;
                $judul = $v->judul;
                $konten = $v->konten;
                $tanggal = $v->tanggal;
                $penulis = PakarSawit::find($v->pakar_sawit_id);

                $temp = [
                    'id' => $id,
                    'judul' => $judul,
                    'konten' => $konten,
                    'penulis' => $penulis->nama,
                    'tanggal' => $tanggal,
                ];
                array_push($artikel, $temp);
            }

            return response()->json([
                'success' => true,
                'id' => $user->id,
                'nama' => $user->nama,
                'artikel' => $artikel,
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

    public function hide($id)
    {
        try {
            $artikel = Artikel::find($id);

            $user = Auth::guard('pakar_api')->user();
            $user_id = $user->id;

            if ($user_id != $artikel->pakar_sawit_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menyembunyikan Artikel orang lain!',
                    'Status' => 403
                ], 403);
            }

            $artikel->hidden = 1;
            $artikel->save();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil disembunyikan',
                'artikel_id' => $artikel->id,
                'judul' => $artikel->judul,
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

    public function unhide($id)
    {
        try {
            $artikel = Artikel::find($id);

            $user = Auth::guard('pakar_api')->user();
            $user_id = $user->id;

            if ($user_id != $artikel->pakar_sawit_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat memunculkan Artikel orang lain!',
                    'Status' => 403
                ], 403);
            }

            $artikel->hidden = 0;
            $artikel->save();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dimunculkan',
                'artikel_id' => $artikel->id,
                'judul' => $artikel->judul,
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
