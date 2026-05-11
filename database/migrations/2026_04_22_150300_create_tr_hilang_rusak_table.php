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
        Schema::create('tr_hilang_rusak', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - kode: VARCHAR(32), NOT NULL
            $table->string('kode', 32);

            // #3 - nama: VARCHAR(255), NOT NULL
            $table->string('nama', 255);

            // #4 - nim: VARCHAR(255), NOT NULL
            $table->string('nim', 255);

            // #5 - golongan_kel...: VARCHAR(255), NOT NULL
            $table->string('golongan_kelompok', 255);

            // #6 - tanggal_sang...: DATE, NOT NULL
            $table->date('tanggal_sanggup');

            // #7 - tr_member_la...: SMALLINT(5), UNSIGNED, NOT NULL (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id');

            // #8 & #9 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #10 - status: TINYINT(3), UNSIGNED, Allow Null
            $table->unsignedTinyInteger('status')->nullable();

            // #11 - tm_laboratori...: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id')->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('tr_member_laboratorium_id', 'fk_tr_hilang_rusak_member')
                  ->references('id')->on('tr_member_laboratorium')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('tm_laboratorium_id', 'fk_tr_hilang_rusak_lab')
                  ->references('id')->on('tm_laboratorium')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_hilang_rusak');
    }
};