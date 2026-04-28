<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_kesiapan_praktek', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('kode', 32);
            $table->integer('tr_matakuliah_kurikulum_id')->unsigned()->nullable();
            $table->integer('tr_matakuliah_dosen_id')->unsigned()->nullable();
            $table->integer('tm_staff_id')->unsigned()->nullable();
            $table->tinyInteger('rekomendasi')->unsigned()->nullable();
            $table->smallInteger('tr_member_laboratorium_id')->unsigned()->nullable();
            $table->smallInteger('tm_minggu_id')->unsigned()->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
            $table->smallInteger('tm_laboratorium_id')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_kesiapan_praktek');
    }
};