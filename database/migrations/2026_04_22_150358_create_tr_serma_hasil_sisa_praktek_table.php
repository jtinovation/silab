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
        Schema::create('tr_serma_hasil_sisa_praktek', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - kode: VARCHAR(32), NOT NULL (Tanpa centang Allow Null)
            $table->string('kode', 32);

            // #3 - tr_matakuliah_dosen_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tr_matakuliah_dosen_id')->nullable();

            // #4 - tr_member_laboratorium_id: SMALLINT(5), UNSIGNED, NOT NULL (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id');

            // #5 & #6 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #7 - tm_minggu_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_minggu_id')->nullable();

            // #8 - tanggal: DATE, Allow Null
            $table->date('tanggal')->nullable();

            // #9 - acara_praktek: TEXT, Allow Null
            $table->text('acara_praktek')->nullable();

            // #10 - tm_laboratorium_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id')->nullable();

            // --- Definisi Foreign Key berdasarkan relasi pada gambar ---

            $table->foreign('tr_matakuliah_dosen_id', 'fk_serma_mk_dosen')
                  ->references('id')->on('tr_matakuliah_dosen')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tr_member_laboratorium_id', 'fk_serma_member')
                  ->references('id')->on('tr_member_laboratorium')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('tm_minggu_id', 'fk_serma_minggu')
                  ->references('id')->on('tm_minggu')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_laboratorium_id', 'fk_serma_lab')
                  ->references('id')->on('tm_laboratorium')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_serma_hasil_sisa_praktek');
    }
};