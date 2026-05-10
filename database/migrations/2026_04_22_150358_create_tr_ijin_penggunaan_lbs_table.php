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
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - is_pegawai: TINYINT(1), Allow Null
            $table->tinyInteger('is_pegawai')->nullable();

            // #4 - tm_staff_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tm_staff_id')->nullable();

            // #5 - nama: VARCHAR(255), Allow Null
            $table->string('nama', 255)->nullable();

            // #6 - nim: VARCHAR(255), Allow Null
            $table->string('nim', 255)->nullable();

            // #7 & #8 - start_date & end_date: DATE, Allow Null
            // Catatan: Di gambar opsi 'Allow Null' dicentang untuk kedua kolom ini.
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // #9 - tm_staff_id_pembimbing (di gambar: tm_staff_id_pe...): INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tm_staff_id_pembimbing')->nullable();

            // #10 - tm_program_studi_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_program_studi_id')->nullable();

            // #11 - tr_member_laboratorium_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id')->nullable();

            // #12 & #13 - created_at & updated_at
            $table->timestamps();

            // #14 - status: TINYINT(3), UNSIGNED, Allow Null
            $table->unsignedTinyInteger('status')->nullable();

            // #15 - tm_laboratorium_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id')->nullable();

            // --- Definisi Foreign Key sesuai relasi di gambar ---
            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tm_staff_id_pembimbing')->references('id')->on('tm_staff')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tm_program_studi_id')->references('id')->on('tm_program_studi')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tr_member_laboratorium_id')->references('id')->on('tr_member_laboratorium')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tm_laboratorium_id')->references('id')->on('tm_laboratorium')->onUpdate('cascade')->onDelete('set null');
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