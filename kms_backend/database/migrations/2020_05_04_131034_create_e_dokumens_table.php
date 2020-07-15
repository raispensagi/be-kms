<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edokumen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('penulis');
            $table->string('tahun');
            $table->string('penerbit');
            $table->string('halaman');
            $table->string('bahasa');
            $table->longText('deskripsi');
            $table->string('file');
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
        Schema::dropIfExists('edokumen');
    }
}
