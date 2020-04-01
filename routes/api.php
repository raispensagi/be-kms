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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** Auth */
//Pakar
Route::group(['prefix' => 'pakar'], function () {
    Route::post('register', 'API\Auth\AuthPakarController@register');
    Route::post('login', 'API\Auth\AuthPakarController@login');

    Route::group(['middleware' => ['pakar.check', 'jwt.auth']], function(){
        Route::post('logout', 'API\Auth\AuthPakarController@logout');
        Route::get('check', 'API\Auth\AuthPakarController@check_privilage');
    });
});


//Petani
Route::group(['prefix' => 'petani'], function (){
    Route::post('register','API\Auth\AuthPetaniController@register');
    Route::post('login','API\Auth\AuthPetaniController@login');

    Route::group(['middleware' => ['petani.check', 'jwt.auth']], function(){
        Route::post('logout','API\Auth\AuthPetaniController@logout');
        Route::get('check','API\Auth\AuthPetaniController@check_privilage');
    });
});


