<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisTable extends Migration
{
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelas_siswa_id');
            $table->foreign('kelas_siswa_id')->references('id')->on('kelas_siswa');

            $table->foreignId('mapel_id');
            $table->foreign('mapel_id')->references('id')->on('mapels');

            $table->unsignedInteger('tugas_1')->nullable();
            $table->unsignedInteger('tugas_2')->nullable();
            $table->unsignedInteger('tugas_3')->nullable();
            $table->unsignedInteger('tugas_4')->nullable();

            $table->unsignedInteger('ulha_1')->nullable();
            $table->unsignedInteger('ulha_2')->nullable();
            $table->unsignedInteger('ulha_3')->nullable();
            $table->unsignedInteger('ulha_4')->nullable();

            $table->unsignedInteger('uts')->nullable();
            $table->unsignedInteger('uas')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilais');
    }
}
