<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tm_barang', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('nama_barang')->nullable();
            $table->string('spesifikasi')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->smallInteger('tm_satuan_id')->unsigned()->nullable();
            $table->tinyInteger('tm_jenis_barang_id')->unsigned()->nullable();
            $table->timestamps();
            $table->integer('qty')->unsigned()->nullable();
            $table->string('kode_barang')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tm_barang');
    }
};