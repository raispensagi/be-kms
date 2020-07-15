<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKontenTable extends Migration
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
            $table->string('kategori')->nullable()->change();
            $table->string('sub_kategori')->nullable()->change();
            $table->string('tipe')->nullable()->change();
            $table->integer('id_tipe')->nullable()->change();
            $table->string('judul')->nullable()->change();
            $table->string('tanggal')->nullable()->change();
            $table->boolean('is_draft')->default(0)->change();
            $table->boolean('is_valid')->default(0)->change();
            $table->boolean('is_hidden')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::create('konten', function (Blueprint $table) {
            $table->string('kategori')->change();
            $table->string('sub_kategori')->change();
            $table->string('tipe')->change();
            $table->integer('id_tipe')->change();
            $table->string('judul')->change();
            $table->string('tanggal')->change();
            $table->boolean('is_draft')->change();
            $table->boolean('is_valid')->change();
            $table->boolean('is_hidden')->change();
        });
    }
}
