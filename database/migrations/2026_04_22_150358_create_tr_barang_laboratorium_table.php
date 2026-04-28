<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_barang_laboratorium', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->integer('stok')->unsigned();
            $table->smallInteger('tm_laboratorium_id')->unsigned();
            $table->integer('tm_barang_id')->unsigned();
            $table->tinyInteger('is_aktif')->unsigned()->nullable();
            $table->timestamps();
            $table->string('kode')->nullable();
            $table->string('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_barang_laboratorium');
    }
};