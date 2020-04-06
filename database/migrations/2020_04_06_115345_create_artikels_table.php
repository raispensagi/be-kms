<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul')->nullable();
            $table->longText('konten')->nullable();
            $table->boolean('draft')->nullable()->default(0);
            $table->boolean('posted')->nullable()->default(0);
            $table->boolean('valid')->nullable()->default(0);
            $table->boolean('hidden')->nullable()->default(0);
            $table->string('tanggal')->nullable();
            $table->integer('pakar_sawit_id');
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
        Schema::dropIfExists('artikel');
    }
}
