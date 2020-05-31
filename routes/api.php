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

// TODO: TEST 1 1
// TODO: Enable CORS
Route::group(['middleware' => ['cors']], function () {
    Route::post('test/change','API\TestingController@change_video');
    Route::post('login', 'API\Auth\LoginController@login');

    // TODO: Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::post('register', 'API\Auth\RegisterController@admin');
        Route::post('register/super', 'API\Auth\RegisterController@super_admin');

        Route::group(['middleware' => ['auth.admin']], function () {
            Route::get('profil', 'API\PakarController@profil');
            Route::post('profil/update', 'API\UserController@update_profil');

            Route::get('user/list', 'API\UserController@get_all');
            Route::post('user/update/{id}', 'API\UserController@update_profil_admin');
            Route::delete('user/delete/{id}', 'API\UserController@delete');

            Route::post('notifikasi/add', 'API\NotifikasiController@add');
            Route::get('notifikasi/all', 'API\NotifikasiController@get_all');
            Route::delete('notifikasi/delete/{id}', 'API\NotifikasiController@delete');

            Route::post('konten/hide/{id}', 'API\Konten\MainController@hide_post');
            Route::post('konten/unhide/{id}', 'API\Konten\MainController@unhide_post');
            Route::delete('konten/delete/{id}', 'API\Konten\MainController@delete');
            Route::get('konten/all', 'API\Konten\MainController@get_all');

            Route::group(['middleware' => ['auth.super']], function () {
                Route::post('create_admin', 'API\Auth\RegisterController@admin');
            });
        });
    });

    // TODO: Validator
    Route::group(['prefix' => 'validator'], function () {
        Route::post('register', 'API\Auth\RegisterController@validator');

        Route::group(['middleware' => ['auth.validator']], function () {
            Route::post('profil/update', 'API\UserController@update_profil');

            Route::post('notifikasi/add', 'API\NotifikasiController@add');

            Route::post('draft/edit/{id}', 'API\Konten\MainController@edit_draft');
            Route::post('draft/post/{id}', 'API\Konten\MainController@draft_to_post');

            Route::get('draft/my', 'API\Konten\MainController@get_my_draft');
            Route::get('post/my', 'API\Konten\MainController@get_my_post');

            Route::get('konten/not_valid', 'API\ValidatorController@get_konten_not_valid');
            Route::get('konten/not_valid/user/{id}', 'API\ValidatorController@get_konten_not_valid_penulis');
            Route::post('konten/validasi/{id}', 'API\ValidatorController@validasi');
            Route::post('konten/revisi/{id}', 'API\ValidatorController@revisi');
            Route::post('konten/hide/{id}', 'API\Konten\MainController@hide_post');
            Route::post('konten/unhide/{id}', 'API\Konten\MainController@unhide_post');
            Route::delete('konten/delete/{id}', 'API\Konten\MainController@delete');
            Route::get('konten/all', 'API\Konten\MainController@get_all');

            Route::group(['prefix' => 'artikel'], function () {
                Route::post('draft', 'API\Konten\ArtikelController@draft');
                Route::post('post', 'API\Konten\ArtikelController@post');
            });
            Route::group(['prefix' => 'video'], function () {
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
            Route::post('profil/update', 'API\UserController@update_profil');

            Route::post('notifikasi/add', 'API\NotifikasiController@add');

            Route::post('bookmark/add/{id}', 'API\BookmarkController@add');
            Route::delete('bookmark/delete/{id}', 'API\BookmarkController@delete');
            Route::get('bookmark','API\BookmarkController@get_all');

            Route::post('draft/edit/{id}', 'API\Konten\MainController@edit_draft');
            Route::post('draft/post/{id}', 'API\Konten\MainController@draft_to_post');

            Route::get('draft/my', 'API\Konten\MainController@get_my_draft');
            Route::get('post/my', 'API\Konten\MainController@get_my_post');
            Route::get('revisi/my', 'API\Konten\MainController@get_revisi');

            Route::group(['prefix' => 'artikel'], function () {
                Route::post('draft', 'API\Konten\ArtikelController@draft');
                Route::post('post', 'API\Konten\ArtikelController@post');
            });
            Route::group(['prefix' => 'video'], function () {
                Route::post('draft', 'API\Konten\VideoAudioController@draft');
                Route::post('post', 'API\Konten\VideoAudioController@post');
            });
            Route::group(['prefix' => 'edokumen'], function () {
                Route::post('draft', 'API\Konten\EDokumenController@draft');
                Route::post('post', 'API\Konten\EDokumenController@post');
            });

            Route::get('riwayat', 'API\RiwayatController@get_all');
        });
    });

    // TODO: Petani
    Route::group(['prefix' => 'petani'], function () {
        Route::post('register', 'API\Auth\RegisterController@petani');

        Route::group(['middleware' => ['auth.petani']], function () {
            Route::post('bookmark/add/{id}', 'API\BookmarkController@add');
            Route::delete('bookmark/delete/{id}', 'API\BookmarkController@delete');
            Route::get('bookmark','API\BookmarkController@get_all');

            Route::get('riwayat', 'API\RiwayatController@get_all');

        });
    });

    // TODO: Universal Auth
    Route::group(['middleware' => ['auth.login']], function () {
        Route::get('profil', 'API\UserController@profil');
        Route::get('profil/show/{id}', 'API\UserController@show_profil');
        Route::post('logout', 'API\LogoutController@logout');

        Route::get('notifikasi/my', 'API\NotifikasiController@get_personal');
        Route::get('notifikasi/show/{id}', 'API\NotifikasiController@show');
        Route::delete('notifikasi/my/delete/{id}', 'API\NotifikasiController@delete_personal');

        Route::group(['prefix' => 'konten'], function () {
            Route::post('pencarian/kategori', 'API\Konten\MainController@search_kategori');
            Route::post('pencarian', 'API\Konten\MainController@search');

            Route::get('post', 'API\Konten\MainController@get_all_post');
            Route::get('artikel', 'API\Konten\MainController@get_all_artikel');
            Route::get('video', 'API\Konten\MainController@get_all_video_audio');
            Route::get('edokumen', 'API\Konten\MainController@get_all_edokumen');
            Route::get('penulis/{id}', 'API\Konten\MainController@get_konten_penulis');
            Route::get('show/{id}', 'API\Konten\MainController@show');
        });
    });

    Route::post('test', 'API\TestingController@check_request');
    Route::post('assign', 'API\NotifikasiController@assign');
});

