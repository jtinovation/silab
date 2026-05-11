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
        Schema::create('tm_minggu', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT
            $table->smallIncrements('id');

            // #2 - minggu_ke: TINYINT(3), UNSIGNED, NOT NULL
            $table->unsignedTinyInteger('minggu_ke');

            // #3 - start_date: DATE, NOT NULL
            $table->date('start_date');

            // #4 - end_date: DATE, NOT NULL
            $table->date('end_date');

            // #5 - tm_tahun_ajaran_id: TINYINT(3), UNSIGNED, Allow Null (FK)
            $table->unsignedTinyInteger('tm_tahun_ajaran_id')->nullable();

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #8 - keterangan: VARCHAR(255), Allow Null
            $table->string('keterangan', 255)->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('tm_tahun_ajaran_id', 'fk_tm_minggu_tahun_ajaran')
                  ->references('id')->on('tm_tahun_ajaran')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_minggu');
    }
};