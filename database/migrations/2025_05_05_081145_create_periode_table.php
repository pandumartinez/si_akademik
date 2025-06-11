<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodeTable extends Migration
{
    public function up()
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id();

            $table->year('tahun');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');

            $table->boolean('aktif');
        });
    }

    public function down()
    {
        Schema::dropIfExists('periode');
    }
}
