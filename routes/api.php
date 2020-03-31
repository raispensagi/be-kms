<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/** Auth */
//Petani
Route::post('/register_petani','API\AuthPetaniController@register');
Route::post('/login_petani','API\AuthPetaniController@login');
Route::get('/logout_petani','API\AuthPetaniController@logout');
//Pakar Sawit
Route::post('/register_pakar','API\AuthPakarController@register');
Route::post('/login_pakar','API\AuthPakarController@login');
Route::get('/logout_pakar','API\AuthPetaniController@logout');

