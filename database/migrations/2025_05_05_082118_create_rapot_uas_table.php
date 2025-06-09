<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapotUasTable extends Migration
{
    public function up()
    {
        Schema::create('rapot_uas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelas_siswa_id');
            $table->foreign('kelas_siswa_id')->references('id')->on('kelas_siswa');

            $table->foreignId('mapel_id');
            $table->foreign('mapel_id')->references('id')->on('mapels');

            $table->unsignedInteger('nilai_pengetahuan')->nullable();
            $table->string('predikat_pengetahuan', 2)->nullable();
            $table->text('deskripsi_pengetahuan')->nullable();

            $table->unsignedInteger('nilai_keterampilan')->nullable();
            $table->string('predikat_keterampilan', 2)->nullable();
            $table->text('deskripsi_keterampilan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rapot_uas');
    }
}
