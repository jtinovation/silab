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
        Schema::create('tr_matakuliah_semester_prodi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tm_program_studi_id')->nullable();
            $table->integer('tm_semester_id')->nullable();
            $table->integer('tm_matakuliah_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('jumlah_golongan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_matakuliah_semester_prodi');
    }
};
