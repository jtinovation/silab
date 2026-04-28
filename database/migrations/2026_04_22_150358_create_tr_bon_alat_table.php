<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_bon_alat', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('kode', 32)->nullable();
            $table->tinyInteger('is_pegawai')->nullable();
            $table->integer('tm_staff_id')->unsigned()->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('nim', 255)->nullable();
            $table->string('golongan_kelompok', 255)->nullable();
            $table->smallInteger('tm_laboratorium_id')->unsigned()->nullable();
            $table->dateTime('tanggal_pinjam')->nullable();
            $table->smallInteger('tr_member_laboratorium_id_pinjam')->unsigned()->nullable();
            $table->dateTime('tanggal_kembali')->nullable();
            $table->tinyInteger('kembali_is_pegawai')->nullable();
            $table->string('kembali_nama', 64)->nullable();
            $table->string('kembali_nim', 15)->nullable();
            $table->string('kembali_golongan_kelompok', 64)->nullable();
            $table->smallInteger('tr_member_laboratorium_id_kembali')->unsigned()->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->integer('kembali_tm_staff_id')->unsigned()->nullable();
            $table->integer('tm_staff_id_peminjam')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_bon_alat');
    }
};