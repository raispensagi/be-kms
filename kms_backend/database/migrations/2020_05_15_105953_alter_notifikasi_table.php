<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropColumn('penulis');
            $table->string('tanggal');
            $table->integer('user_id');
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
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->string('penulis');
            $table->dropColumn('tanggal');
            $table->dropColumn('user_id');
        });
    }
}
