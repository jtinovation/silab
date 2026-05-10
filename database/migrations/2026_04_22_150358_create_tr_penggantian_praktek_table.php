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
        Schema::create('tr_penggantian_praktek', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - jadwal_asli: DATETIME, NOT NULL
            $table->dateTime('jadwal_asli');

            // #3 - jadwal_ganti: DATETIME, NOT NULL
            $table->dateTime('jadwal_ganti');

            // #4 - acara_praktek: VARCHAR(255), NOT NULL
            $table->string('acara_praktek', 255);

            // #5 - tr_kaprodi_id: SMALLINT(5), UNSIGNED, NOT NULL (FK)
            $table->unsignedSmallInteger('tr_kaprodi_id');

            // #6 - tr_member_laboratorium_id: SMALLINT(5), UNSIGNED, NOT NULL (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id');

            // #7 & #8 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #9 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #10 - tr_matakuliah_dosen_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tr_matakuliah_dosen_id')->nullable();

            // #11 - tm_staff_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tm_staff_id')->nullable();

            // --- Definisi Foreign Key sesuai ikon kunci hijau di gambar ---

            $table->foreign('tr_kaprodi_id', 'fk_ganti_kaprodi')
                  ->references('id')->on('tr_kaprodi')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('tr_member_laboratorium_id', 'fk_ganti_member')
                  ->references('id')->on('tr_member_laboratorium')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('tr_matakuliah_dosen_id', 'fk_ganti_mk_dosen')
                  ->references('id')->on('tr_matakuliah_dosen')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_staff_id', 'fk_ganti_staff')
                  ->references('id')->on('tm_staff')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_penggantian_praktek');
    }
};