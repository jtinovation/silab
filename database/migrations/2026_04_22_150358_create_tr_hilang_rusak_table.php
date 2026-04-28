<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_hilang_rusak', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('kode', 32);
            $table->string('nama', 255);
            $table->string('nim', 255);
            $table->string('golongan_kelompok', 255);
            $table->date('tanggal_sanggup');
            $table->smallInteger('tr_member_laboratorium_id')->unsigned();
            $table->timestamps();
            $table->tinyInteger('status')->nullable();
            $table->smallInteger('tm_laboratorium_id')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_hilang_rusak');
    }
};