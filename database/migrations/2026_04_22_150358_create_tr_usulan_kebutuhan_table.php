<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_usulan_kebutuhan', function (Blueprint $table) {
            $table->bigId('id');
            $table->string('kode', 32)->nullable();
            $table->string('acara_praktek', 255);
            $table->tinyInteger('jml_kel')->unsigned();
            $table->string('keterangan', 255)->nullable();
            $table->tinyInteger('status')->unsigned();
            $table->smallInteger('tm_minggu_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->integer('tr_matakuliah_dosen_id')->unsigned()->nullable();
            $table->timestamps();
            $table->date('tanggal')->nullable();
            $table->tinyInteger('jml_gol')->unsigned();
            $table->smallInteger('tm_laboratorium_id')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_usulan_kebutuhan');
    }
};