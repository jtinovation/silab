<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_ijin_penggunaan_lbs', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('kode', 32)->nullable();
            $table->tinyInteger('is_pegawai')->nullable();
            $table->integer('tm_staff_id')->unsigned()->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('nim', 255)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('tm_staff_id_pembimbing')->unsigned()->nullable();
            $table->smallInteger('tm_program_studi_id')->unsigned()->nullable();
            $table->smallInteger('tr_member_laboratorium_id')->unsigned()->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->nullable();
            $table->smallInteger('tm_laboratorium_id')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_ijin_penggunaan_lbs');
    }
};