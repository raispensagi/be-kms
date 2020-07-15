<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('validasi');

        Schema::create('revisi', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('komentar');
            $table->string('tanggal');
            $table->integer('konten_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revisi');

        Schema::create('validasi', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('komentar');
            $table->string('tanggal');
            $table->integer('konten_id');
            $table->timestamps();
        });
    }
}
