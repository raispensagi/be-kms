<?php

namespace App\Http\Controllers\API\Konten;

use App\Http\Controllers\Controller;
use App\Konten;
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
                        'id_penulis' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Video atau Audio tersimpan',
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
                        'id_penulis' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Video atau Audio tersimpan',
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
