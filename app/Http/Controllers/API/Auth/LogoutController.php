<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //
    public function admin()
    {
        try {
            Auth::guard('admin_api')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Log Out',
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

    public function validator()
    {
        try {
            Auth::guard('validator_api')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Log Out',
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

    public function pakar_sawit()
    {
        try {
            Auth::guard('pakar_api')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Log Out',
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

    public function petani()
    {
        try {
            Auth::guard('petani_api')->logout();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Log Out',
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
