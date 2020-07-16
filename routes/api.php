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

    /** TODO: Testing and Debugging API */
    Route::post('test', 'API\TestingController@check_request');
    Route::post('assign', 'API\NotifikasiController@assign');
    Route::post('delete_n', 'API\NotifikasiController@delete_useless');
    Route::post('test/change', 'API\TestingController@change_video');
    Route::get('rekap', 'API\TestingController@rekap_data');

    // Halaman Register
    Route::post('petani/register', 'API\Auth\RegisterController@petani');
    Route::post('pakar/register', 'API\Auth\RegisterController@pakar_sawit');
    Route::post('validator/register', 'API\Auth\RegisterController@validator');
    Route::post('admin/register', 'API\Auth\RegisterController@admin');
    Route::post('admin/register/super', 'API\Auth\RegisterController@super_admin');
    // Halaman Login
    Route::post('login', 'API\Auth\LoginController@login');

    /** Semua Peran */
    Route::middleware(['check.role:super,admin,validator,pakar,petani'])->group(function () {
        // Halaman Logout
        Route::post('logout', 'API\Auth\LogoutController@logout');

        // Profil
        Route::get('profil', 'API\UserController@profil');
        Route::get('profil/show/{id}', 'API\UserController@show_profil');

        // Notifikasi
        Route::get('notifikasi/my', 'API\NotifikasiController@get_personal');
        Route::get('notifikasi/show/{id}', 'API\NotifikasiController@show');
        Route::delete('notifikasi/my/delete/{id}', 'API\NotifikasiController@delete_personal');

        // Konten
        Route::group(['prefix' => 'konten'], function () {
            Route::get('pencarian/kategori', 'API\Konten\MainController@search_kategori');
            Route::get('pencarian', 'API\Konten\MainController@search');

            Route::get('post', 'API\Konten\MainController@get_all_post');
            Route::get('artikel', 'API\Konten\MainController@get_all_artikel');
            Route::get('video', 'API\Konten\MainController@get_all_video_audio');
            Route::get('edokumen', 'API\Konten\MainController@get_all_edokumen');
            Route::get('penulis/{id}', 'API\Konten\MainController@get_konten_penulis');
            Route::get('show/{id}', 'API\Konten\MainController@show');
        });
    });

    /** Pakar dan Petani */
    Route::middleware(['check.role:pakar,petani'])->group(function () {
        // Bookmark
        Route::post('bookmark/add/{id}', 'API\BookmarkController@add');
        Route::get('bookmark', 'API\BookmarkController@get_all');
        Route::delete('bookmark/delete/{id}', 'API\BookmarkController@delete');

        // Riwayat
        Route::get('riwayat', 'API\RiwayatController@get_all');
    });

    /** Pakar dan Validator */
    Route::middleware(['check.role:pakar,validator'])->group(function () {
        // Konten
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
        Route::post('draft/edit/{id}', 'API\Konten\MainController@edit_draft');
        Route::post('draft/post/{id}', 'API\Konten\MainController@draft_to_post');
        Route::get('draft/my', 'API\Konten\MainController@get_my_draft');
        Route::get('post/my', 'API\Konten\MainController@get_my_post');
    });

    /** Super Admin, Admin, Pakar, dan Validator */
    Route::middleware(['check.role:super,admin,validator,pakar'])->group(function () {
        // Profil
        Route::post('profil/update', 'API\UserController@update_profil');
        // Notifikasi
        Route::post('notifikasi/add', 'API\NotifikasiController@add');
    });

    /** Super Admin, Admin, dan Validator */
    Route::middleware(['check.role:super,admin,validator'])->group(function () {
        // Konten
        Route::post('konten/hide/{id}', 'API\Konten\MainController@hide_post');
        Route::post('konten/unhide/{id}', 'API\Konten\MainController@unhide_post');
        Route::delete('konten/delete/{id}', 'API\Konten\MainController@delete');
        Route::get('konten/all', 'API\Konten\MainController@get_all');
    });

    /** Admin dan Super Admin */
    Route::middleware(['check.role:super,admin'])->group(function () {
        // Pengguna
        Route::get('user/list', 'API\UserController@get_all');
        Route::post('user/update/{id}', 'API\UserController@update_profil_admin');
        Route::delete('user/delete/{id}', 'API\UserController@delete');

        // Notifikasi
        Route::get('notifikasi/all', 'API\NotifikasiController@get_all');
        Route::delete('notifikasi/delete/{id}', 'API\NotifikasiController@delete');
    });

    /** Super Admin Only */
    Route::middleware(['check.role:super'])->group(function () {
        Route::post('create_admin', 'API\Auth\RegisterController@admin');
    });

    /** Pakar Only */
    Route::middleware(['check.role:pakar'])->group(function () {
        Route::get('revisi/my', 'API\Konten\MainController@get_revisi');
    });

    /** Validator Only */
    Route::middleware(['check.role:validator'])->group(function () {
        // Validasi
        Route::get('konten/not_valid', 'API\ValidatorController@get_konten_not_valid');
        Route::get('konten/not_valid/user/{id}', 'API\ValidatorController@get_konten_not_valid_penulis');
        Route::post('konten/validasi/{id}', 'API\ValidatorController@validasi');
        Route::post('konten/revisi/{id}', 'API\ValidatorController@revisi');
    });

});

