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

// TODO: Enable CORS
Route::group(['middleware' => ['cors']], function () {

    Route::post('login', 'API\Auth\LoginController@login');
    Route::post('logout', 'API\Auth\LogoutController@logout');

    // TODO: Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::post('register', 'API\Auth\RegisterController@admin');
        Route::post('register/super', 'API\Auth\RegisterController@super_admin');

        Route::group(['middleware' => ['auth.admin']], function () {

        });
    });

    // TODO: Validator
    Route::group(['prefix' => 'validator'], function () {
        Route::post('register', 'API\Auth\RegisterController@validator');

        Route::group(['middleware' => ['auth.validator']], function () {

            Route::post('draft/edit/{id}', 'API\Konten\MainController@edit_draft');
            Route::post('draft/post/{id}', 'API\Konten\MainController@draft_to_post');
            Route::get('konten/not_valid', 'API\Konten\MainController@get_konten_not_valid');
//            Route::get('konten/')

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

    // TODO: Pakar
    Route::group(['prefix' => 'pakar'], function () {
        Route::post('register', 'API\Auth\RegisterController@pakar_sawit');

        Route::group(['middleware' => ['auth.pakar']], function () {
            Route::get('profil', 'API\PakarController@profil');

            Route::post('bookmark/add/{id}', 'API\BookmarkController@add');
            Route::post('bookmark/delete/{id}', 'API\BookmarkController@delete');
            Route::get('bookmark','API\BookmarkController@get_all');

            Route::post('draft/edit/{id}', 'API\Konten\MainController@edit_draft');
            Route::post('draft/post/{id}', 'API\Konten\MainController@draft_to_post');

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

    // TODO: Petani
    Route::group(['prefix' => 'petani'], function () {
        Route::post('register', 'API\Auth\RegisterController@petani');

        Route::group(['middleware' => ['auth.petani']], function () {
            Route::post('bookmark/add/{id}', 'API\BookmarkController@add');
            Route::post('bookmark/delete/{id}', 'API\BookmarkController@delete');
            Route::get('bookmark','API\BookmarkController@get_all');
        });
    });

    // TODO: Universal Auth
    Route::group(['middleware' => ['auth.login']], function () {
        Route::get('profil', 'API\UserController@profil');
        Route::post('logout', 'API\LogoutController@logout');

        Route::get('konten/{id}', 'API\Konten\MainController@show');
        Route::group(['prefix' => 'konten'], function () {
            Route::post('pencarian/kategori', 'API\Konten\MainController@search_kategori');
            Route::post('pencarian', 'API\Konten\MainController@search');
            Route::get('post', 'API\Konten\MainController@get_all_post');

            Route::get('artikel', 'API\Konten\MainController@get_all_artikel');
            Route::get('video_audio', 'API\Konten\MainController@get_all_video_audio');
            Route::get('edokumen', 'API\Konten\MainController@get_all_edokumen');
            Route::get('penulis/{id}', 'API\Konten\MainController@get_konten_penulis');

        });
    });
});

