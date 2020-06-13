<?php

namespace App\Http\Controllers\API\Konten;

use App\Http\Controllers\Controller;
use App\Konten;
use App\VideoAudio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    private function check($var){
        $validator = Validator::make($var->all(), [
            'judul' => 'required',
            'kategori' => 'required',
            'isi' => 'required',
            'video_audio' => 'required',
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
                    if ($request->file('video_audio') != null) {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => 'default.png',
                        ]);
                        $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $video->id);
                        if ($file != NULL) {
                            $video->video_audio = $file;
                            $video->save();
                        }
                    } else {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => $request->video_audio,
                        ]);
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Video',
                        'id_tipe' => $video->id,
                        'is_draft' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Video tersimpan',
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
                    if ($request->file('video_audio') != null) {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => 'default.png',
                        ]);
                        $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $video->id);
                        if ($file != NULL) {
                            $video->video_audio = $file;
                            $video->save();
                        }
                    } else {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => $request->video_audio,
                        ]);
                    }
                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Video',
                        'id_tipe' => $video->id,
                        'is_draft' => 0,
                        'is_valid' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Video tersimpan',
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
                    if ($request->file('video_audio') != null) {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => 'default.png',
                        ]);
                        $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $video->id);
                        if ($file != NULL) {
                            $video->video_audio = $file;
                            $video->save();
                        }
                    } else {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => $request->video_audio,
                        ]);
                    }
                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Video',
                        'id_tipe' => $video->id,
                        'is_draft' => 1,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Video tersimpan',
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
                    if ($request->file('video_audio') != null) {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => 'default.png',
                        ]);
                        $file = $this->upload_file($request, 'video_audio', 'VideoAudio', $video->id);
                        if ($file != NULL) {
                            $video->video_audio = $file;
                            $video->save();
                        }
                    } else {
                        $video = VideoAudio::create([
                            'isi' => $request->isi,
                            'video_audio' => $request->video_audio,
                        ]);
                    }

                    $konten = Konten::create([
                        'judul' => $request->judul,
                        'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                        'kategori' => $request->kategori,
                        'sub_kategori' => $request->sub_kategori,
                        'tipe' => 'Video',
                        'id_tipe' => $video->id,
                        'is_draft' => 0,
                        'user_id' => $user->id,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Video tersimpan',
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
