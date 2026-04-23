<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tr_bon_alat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->boolean('is_pegawai');
            $table->integer('tm_staff_id')->nullable();
            $table->string('nama');
            $table->string('nim');
            $table->string('golongan_kelompok');
            $table->dateTime('tanggal_pinjam');
            $table->integer('tr_member_laboratorium_id_pinjam')->nullable();
            $table->dateTime('tanggal_kembali');
            $table->string('pengembali');
            $table->integer('tr_member_laboratorium_id_kembali')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_bon_alat');
    }
};
