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
        Schema::create('tm_laboratorium', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT
            $table->smallIncrements('id');

            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - laboratorium: VARCHAR(64), Allow Null
            $table->string('laboratorium', 64)->nullable();

            // #4 - tm_jurusan_id: TINYINT(3), UNSIGNED, NOT NULL (FK)
            $table->unsignedTinyInteger('tm_jurusan_id');

            // #5 - is_aktif: TINYINT(1), Default '1'
            $table->tinyInteger('is_aktif')->default(1);

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #8 - singkatan: VARCHAR(255), Allow Null
            $table->string('singkatan', 255)->nullable();

            // #9 - warna: VARCHAR(255), Allow Null
            $table->string('warna', 255)->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('tm_jurusan_id', 'fk_tm_lab_jurusan')
                  ->references('id')->on('tm_jurusan')
                  ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_laboratorium');
    }
};