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

// Enable CORS
Route::group(['middleware' => ['cors']], function () {

    //Pakar
    Route::group(['prefix' => 'pakar'], function () {
        Route::post('register', 'API\Auth\AuthPakarController@register');
        Route::post('login', 'API\Auth\AuthPakarController@login');

        Route::group(['middleware' => ['pakar.check']], function () {
            Route::post('logout', 'API\Auth\AuthPakarController@logout');
            Route::get('profil', 'API\PakarController@profil');
        });
    });

    //Petani
    Route::group(['prefix' => 'petani'], function () {
        Route::post('register', 'API\Auth\AuthPetaniController@register');
        Route::post('login', 'API\Auth\AuthPetaniController@login');

        Route::group(['middleware' => ['petani.check']], function () {
            Route::post('logout', 'API\Auth\AuthPetaniController@logout');
            Route::get('profil', 'API\PetaniController@profil');
        });
    });

    //Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', 'API\Auth\AuthAdminController@login');

        Route::group(['middleware' => ['admin.check']], function () {
            Route::post('logout', 'API\Auth\AuthAdminController@logout');
        });
    });

    //Super Admin
    Route::group(['prefix' => 'super'], function () {
        Route::post('login', 'API\Auth\AuthSuperController@login');

        Route::group(['middleware' => ['super.check']], function () {
            Route::post('logout', 'API\Auth\AuthSuperController@logout');
        });
    });

    //Validator
    Route::group(['prefix' => 'validator'], function () {
        Route::post('login', 'API\Auth\AuthValidController@login');

        Route::group(['middleware' => ['validator.check']], function () {
            Route::post('logout', 'API\Auth\AuthValidController@logout');
        });
    });
});

