<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tm_laboratorium', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->string('kode')->nullable();
            $table->string('laboratorium')->nullable();
            $table->tinyInteger('tm_jurusan_id')->unsigned();
            $table->tinyInteger('is_aktif')->unsigned()->nullable();
            $table->timestamps();
            $table->string('singkatan')->nullable();
            $table->string('warna')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tm_laboratorium');
    }
};