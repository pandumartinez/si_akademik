<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokMapelTable extends Migration
{
    public function up()
    {
        Schema::create('kelompok_mapel', function (Blueprint $table) {
            $table->id();

            $table->timestamps();

            $table->string('nama_kelompok');
            $table->char('kode', 1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelompok_mapel');
    }
}
