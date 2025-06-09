<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapotUtsTable extends Migration
{
    public function up()
    {
        Schema::create('rapot_uts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kelas_siswa_id');
            $table->foreign('kelas_siswa_id')->references('id')->on('kelas_siswa');

            $table->foreignId('mapel_id');
            $table->foreign('mapel_id')->references('id')->on('mapels');

            $table->unsignedInteger('tugas_1')->nullable();
            $table->unsignedInteger('tugas_2')->nullable();

            $table->unsignedInteger('ulha_1')->nullable();
            $table->unsignedInteger('ulha_2')->nullable();

            $table->unsignedInteger('uts')->nullable();

            $table->unsignedInteger('praktik')->nullable();
            $table->string('sikap', 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rapot_uts');
    }
}
