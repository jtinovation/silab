<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_penggantian_praktek', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->dateTime('jadwal_asli');
            $table->dateTime('jadwal_ganti');
            $table->string('acara_praktek', 255);
            $table->smallInteger('tr_kaprodi_id')->unsigned();
            $table->smallInteger('tr_member_laboratorium_id')->unsigned();
            $table->timestamps();
            $table->string('kode', 32)->nullable();
            $table->integer('tr_matakuliah_dosen_id')->unsigned()->nullable();
            $table->integer('tm_staff_id')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_penggantian_praktek');
    }
};