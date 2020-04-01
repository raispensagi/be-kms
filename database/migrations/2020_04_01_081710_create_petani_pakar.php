<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetaniPakar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petani', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('nomor_telefon')->unique()->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('password');
            $table->timestamps();
        });
        Schema::create('pakar_sawit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('nomor_telefon')->unique()->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('petani');
        Schema::dropIfExists('pakar_sawit');
    }
}
