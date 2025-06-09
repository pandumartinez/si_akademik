<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiGuruTable extends Migration
{
    public function up()
    {
        Schema::create('absensi_guru', function (Blueprint $table) {
            $table->id();

            $table->timestamps();

            $table->foreignId('guru_id');
            $table->foreign('guru_id')->references('id')->on('gurus');

            $table->enum('keterangan', [
                'hadir',
                'selesai mengajar',
                'bertugas keluar',
                'terlambat',
                'izin',
                'sakit',
                'tanpa keterangan',
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi_guru');
    }
}
