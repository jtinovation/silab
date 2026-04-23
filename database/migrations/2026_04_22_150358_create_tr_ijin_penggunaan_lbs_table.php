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
        Schema::create('tr_ijin_penggunaan_lbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->boolean('is_pegawai');
            $table->integer('tm_staff_id')->nullable();
            $table->string('nama');
            $table->string('nim');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('tm_staff_id_pembimbing')->nullable();
            $table->integer('tm_program_studi_id')->nullable();
            $table->integer('tr_member_laboratorium_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_ijin_penggunaan_lbs');
    }
};
