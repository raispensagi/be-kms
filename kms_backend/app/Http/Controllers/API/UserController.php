<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function profil()
    {
        try {

            $user = Auth::guard('api')->user();

            return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => array($user),
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

    public function show_profil($id)
    {
        try {
            if (User::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ada',
                    'Status' => 404
                ], 404);
            }
            $user = User::where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $user,
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
            $user = User::get();

            return response()->json([
                'success' => true,
                'message' => 'Data',
                'data' => $user,
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

    public function update_profil(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
//            dd(' '. $request->nama. ' ' . $user->nama);
            if ($request->nama != null) {
                $user->nama = $request->nama;
//                dd('tr');
            }
            if ($request->email != null) {
                $user->email = $request->email;
            }
            if ($request->nomor_telefon != null) {
                $user->nomor_telefon = $request->nomor_telefon;
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil telah di-update',
                'data' => $user,
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

    public function update_profil_admin($id, Request $request)
    {
        try {
            if (User::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ada',
                    'Status' => 404
                ], 404);
            }
            $user = User::where('id', $id)->first();
            if ($request->nama != null) {
                $user->nama = $request->nama;
            }
            if ($request->email != null) {
                $user->email = $request->email;
            }
            if ($request->nomor_telefon != null) {
                $user->nomor_telefon = $request->nomor_telefon;
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil telah di-update',
                'data' => $user,
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
            if (User::where('id', $id)->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ada',
                    'Status' => 404
                ], 404);
            }
            $user = User::where('id', $id)->first();
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User telah dihapus',
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
