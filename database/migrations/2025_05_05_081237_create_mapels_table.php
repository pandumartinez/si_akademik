<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapelsTable extends Migration
{
    public function up()
    {
        Schema::create('mapels', function (Blueprint $table) {
            $table->id();

            $table->string('nama_mapel', 50);
            $table->foreignId('kelompok_mapel');
            $table->foreign('kelompok_mapel')->references('id')->on('kelompok_mapel');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mapels');
    }
}
