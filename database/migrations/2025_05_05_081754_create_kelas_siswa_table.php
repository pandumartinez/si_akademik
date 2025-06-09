<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasSiswaTable extends Migration
{
    public function up()
    {
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('periode_id');
            $table->foreign('periode_id')->references('id')->on('periode');

            $table->foreignId('kelas_id');
            $table->foreign('kelas_id')->references('id')->on('kelas');

            $table->foreignId('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas_siswa');
    }
}
