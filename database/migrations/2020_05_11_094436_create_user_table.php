<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('petani');
        Schema::dropIfExists('pakar_sawit');
        Schema::dropIfExists('validator');
        Schema::dropIfExists('admin');

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_telefon')->nullable();
            $table->string('password');
            $table->string('peran');
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
        Schema::dropIfExists('user');

        Schema::create('petani', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('nomor_telefon')->unique()->nullable();
            $table->string('password');
            $table->string('foto')->default('default.png');
            $table->timestamps();
        });
        Schema::create('pakar_sawit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('foto')->default('default.png');
            $table->string('password');
            $table->timestamps();
        });
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->boolean('is_super')->default(0);
            $table->timestamps();
        });
        Schema::create('validator', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('foto')->default('default.png');
            $table->string('password');
            $table->timestamps();
        });
    }
}
