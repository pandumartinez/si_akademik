<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->foreignId('kelas_id');
            $table->foreign('kelas_id')->references('id')->on('kelas');

            $table->foreignId('mapel_id');
            $table->foreign('mapel_id')->references('id')->on('mapels');

            $table->foreignId('guru_id');
            $table->foreign('guru_id')->references('id')->on('gurus');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwals');
    }
}
