<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeskripsiRapotTable extends Migration
{
    public function up()
    {
        Schema::create('deskripsi_rapot', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id');
            $table->foreign('guru_id')->references('id')->on('gurus');

            $table->enum('jenis', ['pengetahuan', 'keterampilan']);

            $table->string('predikat', 2);
            $table->text('deskripsi');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deskripsi_rapot');
    }
}
