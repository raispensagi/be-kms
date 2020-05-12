<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKontenTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('konten', function (Blueprint $table) {
            $table->renameColumn('id_penulis', 'user_id');
        });
        Schema::table('bookmark', function (Blueprint $table) {
            $table->renameColumn('id_petani', 'user_id');
            $table->renameColumn('id_konten', 'konten_id');
            $table->dropColumn('id_pakar_sawit');
        });
        Schema::table('riwayat', function (Blueprint $table) {
            $table->renameColumn('id_petani', 'user_id');
            $table->renameColumn('id_konten', 'konten_id');
            $table->dropColumn('id_pakar_sawit');
        });

        Schema::dropIfExists('penulis');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('konten', function (Blueprint $table) {
            $table->renameColumn('user_id', 'id_penulis');
        });
        Schema::table('bookmark', function (Blueprint $table) {
            $table->renameColumn('user_id', 'id_petani');
            $table->renameColumn('konten_id', 'id_konten');
            $table->integer('id_pakar_sawit')->nullable();
        });
        Schema::table('riwayat', function (Blueprint $table) {
            $table->renameColumn('user_id', 'id_petani');
            $table->renameColumn('konten_id', 'id_konten');
            $table->integer('id_pakar_sawit')->nullable();
        });

        Schema::create('penulis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('peran');
            $table->timestamps();
        });
    }
}
