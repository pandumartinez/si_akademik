<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatanGuruTable extends Migration
{
    public function up()
    {
        Schema::create('jabatan_guru', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jabatan_id');
            $table->foreign('jabatan_id')->references('id')->on('jabatan');

            $table->foreignId('guru_id');
            $table->foreign('guru_id')->references('id')->on('gurus');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jabatan_guru');
    }
}
