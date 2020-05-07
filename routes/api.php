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
        Route::post('register', 'API\Auth\RegisterController@pakar_sawit');
        Route::post('login', 'API\Auth\LoginController@pakar_sawit');

        Route::post('bookmark/add/{id}', 'API\BookmarkController@add');
        Route::post('bookmark/delete/{id}', 'API\BookmarkController@delete');
        Route::get('bookmark','API\BookmarkController@get_all');

        Route::group(['middleware' => ['auth.pakar']], function () {
            Route::post('logout', 'API\Auth\LogoutController@pakar_sawit');
            Route::get('profil', 'API\PakarController@profil');

            Route::group(['prefix' => 'artikel'], function () {
                Route::post('draft', 'API\Konten\ArtikelController@draft');
                Route::post('post', 'API\Konten\ArtikelController@post');
            });
            Route::group(['prefix' => 'video_audio'], function () {
                Route::post('draft', 'API\Konten\VideoAudioController@draft');
                Route::post('post', 'API\Konten\VideoAudioController@post');
            });
            Route::group(['prefix' => 'edokumen'], function () {
                Route::post('draft', 'API\Konten\EDokumenController@draft');
                Route::post('post', 'API\Konten\EDokumenController@post');
            });
        });
    });

    //Petani
    Route::group(['prefix' => 'petani'], function () {
        Route::post('register', 'API\Auth\RegisterController@petani');
        Route::post('login', 'API\Auth\LoginController@petani');

        Route::group(['middleware' => ['auth.petani']], function () {
            Route::post('logout', 'API\Auth\LogoutController@petani');
        });
    });

    //Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::post('register', 'API\Auth\RegisterController@admin');
        Route::post('login', 'API\Auth\LoginController@admin');

        Route::group(['middleware' => ['auth.admin']], function () {
            Route::post('logout', 'API\Auth\LogoutController@admin');
        });
    });


    //Validator
    Route::group(['prefix' => 'validator'], function () {
        Route::post('register', 'API\Auth\RegisterController@validator');
        Route::post('login', 'API\Auth\LoginController@validator');

        Route::group(['middleware' => ['auth.validator']], function () {
            Route::post('logout', 'API\Auth\LogoutController@validator');

            Route::group(['prefix' => 'artikel'], function () {
                Route::post('draft', 'API\Konten\ArtikelController@draft');
                Route::post('post', 'API\Konten\ArtikelController@post');
            });
            Route::group(['prefix' => 'video_audio'], function () {
                Route::post('draft', 'API\Konten\VideoAudioController@draft');
                Route::post('post', 'API\Konten\VideoAudioController@post');
            });
            Route::group(['prefix' => 'edokumen'], function () {
                Route::post('draft', 'API\Konten\EDokumenController@draft');
                Route::post('post', 'API\Konten\EDokumenController@post');
            });
        });
    });

// Universal Auth
    Route::group(['middleware' => ['auth.login']], function () {
        Route::group(['prefix' => 'konten'], function () {
            Route::post('pencarian/kategori', 'API\Konten\MainController@search_kategori');
            Route::post('pencarian', 'API\Konten\MainController@search');
            Route::post('draft/edit/{id}', 'API\Konten\MainController@edit_draft');
            Route::post('draft/post/{id}', 'API\Konten\MainController@draft_to_post');

            Route::get('penulis/{id}', 'API\Konten\MainController@get_konten_penulis');

        });

        Route::get('konten', 'API\Konten\MainController@get_all');
        Route::get('konten/{id}', 'API\Konten\MainController@show');
    });
});

