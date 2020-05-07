<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konten', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kategori');
            $table->string('sub_kategori');
            $table->string('tipe');
            $table->integer('id_tipe');
            $table->string('judul');
            $table->string('tanggal');
            $table->boolean('is_draft');
            $table->boolean('is_valid');
            $table->boolean('is_hidden');
            $table->integer('id_penulis');
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
        Schema::dropIfExists('konten');
    }
}
