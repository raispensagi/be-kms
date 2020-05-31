<?php

namespace App\Http\Controllers\API;

use App\Bookmark;
use App\Http\Controllers\Controller;
use App\Konten;
use App\Notifikasi;
use App\NotifikasiUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    //
    public function add(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();

            $notifikasi = Notifikasi::create([
                'headline' => $request->headline,
                'isi' => $request->isi,
                'tanggal' => Carbon::now()->format('d F Y H:i:s'),
                'user_id' => $user->id
            ]);

            $user_all = User::get();
            foreach ($user_all as $u) {
                NotifikasiUser::create([
                    'user_id' => $u->id,
                    'notifikasi_id' => $notifikasi->id,
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi sudah dibuat',
                'id' => $notifikasi->id,
                'headline' => $request->headline,
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
            $notifikasi = Notifikasi::where('id', $id)->first();
            $user = User::where('id', $notifikasi->user_id)->first();
            $var = array([
                'headline' => $notifikasi->headline,
                'isi' => $notifikasi->isi,
                'tanggal' => $notifikasi->tanggal,
                ''
            ]);

            return response()->json([
                'success' => true,
                'notifikasi' => $notifikasi,
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

    public function get_all()
    {
        try {
            $notifikasi = Notifikasi::get();

            return response()->json([
                'success' => true,
                'notifikasi' => $notifikasi,
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

    public function get_personal()
    {
        try {
            $user = Auth::guard('api')->user();
            $notifikasi = NotifikasiUser::where('user_id', $user->id)->get();
            $var = array();
            foreach ($notifikasi as $n) {
                $temp = Notifikasi::where('id', $n->notifikasi_id)->first();
                array_push($var, $temp);
            }

            return response()->json([
                'success' => true,
                'notifikasi' => $var,
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

    public function delete($id)
    {
        try {
            $notifikasi = Notifikasi::where('id', $id)->first();
            $notifikasi->delete();

            $pivot = NotifikasiUser::where('notifikasi_id',$id)->get();
            foreach ($pivot as $p) {
                $p->delete();
            }

            return response()->json([
                'success' => true,
                'pesan' => 'Notifikasi terhapus',
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

    public function delete_personal($id)
    {
        try {
            $user = Auth::guard('api')->user();

            $pivot = NotifikasiUser::where('notifikasi_id',$id)->where('user_id',$user->id)->first();
            $pivot->delete();

            return response()->json([
                'success' => true,
                'pesan' => 'Notifikasi terhapus',
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

    public function assign() {
        try {
            $notifikasi = Notifikasi::get();
            $user = User::get();

            foreach ($user as $u) {
                foreach ($notifikasi as $n){
                    if (NotifikasiUser::where('user_id', $u->id)->where('notifikasi_id', $n->id)->exists()) {
                        continue;
                    } else {
                        NotifikasiUser::create([
                            'user_id' => $u->id,
                            'notifikasi_id' => $n->id,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'pesan' => 'Assigned',
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
