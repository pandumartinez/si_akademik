<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiSiswaTable extends Migration
{
    public function up()
    {
        Schema::create('absensi_siswa', function (Blueprint $table) {
            $table->id();

            $table->timestamps();

            $table->foreignId('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas');

            $table->enum('keterangan', [
                'izin',
                'sakit',
                'tanpa keterangan',
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi_siswa');
    }
}
