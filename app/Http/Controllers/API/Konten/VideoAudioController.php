<?php

namespace App\Http\Controllers\API\Konten;

use App\Artikel;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Penulis;
use App\VideoAudio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoAudioController extends Controller
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
                $user = $this->check_user();
//                dd($user[0]->nama);
                if (Penulis::where('nama', '=', $user[0]->nama)->exists()) {
                    $penulis = Penulis::where('nama', '=', $user[0]->nama)->first();
                } else {
                    $penulis = Penulis::create([
                        'nama' => $user[0]->nama,
                        'peran' => $user[1],
                    ]);
                }

                $video = VideoAudio::create([
                    'isi' => $request->isi,
                    'video_audio' => 'default.png',
                ]);

                $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $video->id);
                if ($file != NULL) {
                    $video->video_audio = $file;
                    $video->save();
                }

                $konten = Konten::create([
                    'judul' => $request->judul,
                    'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                    'kategori' => $request->kategori,
                    'sub_kategori' => $request->sub_kategori,
                    'tipe' => 'VideoAudio',
                    'id_tipe' => $video->id,
                    'is_draft' => 1,
                    'id_penulis' => $penulis->id,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Video atau Audio tersimpan',
                    'judul' => $request->judul,
                    'kategori' => $request->kategori,
                    'sub_kategori' => $request->sub_kategori,
                    'Status' => 201
                ], 201);
            };
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
                $user = $this->check_user();
//                dd($user[0]->nama);
                if (Penulis::where('nama', '=', $user[0]->nama)->exists()) {
                    $penulis = Penulis::where('nama', '=', $user[0]->nama)->first();
                } else {
                    $penulis = Penulis::create([
                        'nama' => $user[0]->nama,
                        'peran' => $user[1],
                    ]);
                }

                $video = VideoAudio::create([
                    'isi' => $request->isi,
                    'video_audio' => 'default.png',
                ]);

                $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $video->id);
                if ($file != NULL) {
                    $video->video_audio = $file;
                    $video->save();
                }

                $konten = Konten::create([
                    'judul' => $request->judul,
                    'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                    'kategori' => $request->kategori,
                    'sub_kategori' => $request->sub_kategori,
                    'tipe' => 'VideoAudio',
                    'id_tipe' => $video->id,
                    'is_draft' => 0,
                    'id_penulis' => $penulis->id,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Video atau Audio terunggah, menunggu validasi',
                    'judul' => $request->judul,
                    'kategori' => $request->kategori,
                    'sub_kategori' => $request->sub_kategori,
                    'Status' => 201
                ], 201);
            };
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'Status' => 500
            ], 500);
        }
    }

}
