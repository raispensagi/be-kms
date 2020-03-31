<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePakarSawitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pakar_sawit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('nomor_telefon')->nullable();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('jenis_kelamin')->nullable();
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
        Schema::dropIfExists('pakar_sawit');
    }
}
