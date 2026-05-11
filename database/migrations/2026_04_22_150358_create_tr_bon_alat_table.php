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
        Schema::create('tr_bon_alat', function (Blueprint $table) {
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

            // #7 - golongan_kelompok: VARCHAR(255), Allow Null
            $table->string('golongan_kelompok', 255)->nullable();

            // #8 - tm_laboratorium_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id')->nullable();

            // #9 - tanggal_pinjam: DATETIME, Allow Null
            $table->dateTime('tanggal_pinjam')->nullable();

            // #10 - tr_member_laboratorium_id (di gambar): SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id')->nullable();

            // #11 - tanggal_kembali: DATETIME, Allow Null
            $table->dateTime('tanggal_kembali')->nullable();

            // #12 - kembali_is_pegawai: TINYINT(3), Allow Null
            $table->tinyInteger('kembali_is_pegawai')->nullable();

            // #13 - kembali_nama: VARCHAR(64), Allow Null
            $table->string('kembali_nama', 64)->nullable();

            // #14 - kembali_nim: VARCHAR(15), Allow Null
            $table->string('kembali_nim', 15)->nullable();

            // #15 - kembali_golongan_kelompok: VARCHAR(64), Allow Null
            $table->string('kembali_golongan_kelompok', 64)->nullable();

            // #16 - tr_member_laboratorium_id_kembali (di gambar tr_member_lab...): SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id_kembali')->nullable();

            // #17 - status: TINYINT(3), Allow Null, Default '1'
            $table->tinyInteger('status')->nullable()->default(1);

            // #18 & #19 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #20 - kembali_tm_staff_id: INT(10), UNSIGNED, Allow Null
            $table->unsignedInteger('kembali_tm_staff_id')->nullable();

            // #21 - tm_staff_id_peminjam (di gambar tm_staff_id_pe...): INT(10), UNSIGNED, Allow Null
            $table->unsignedInteger('tm_staff_id_pembimbing')->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tm_laboratorium_id')->references('id')->on('tm_laboratorium')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tr_member_laboratorium_id')->references('id')->on('tr_member_laboratorium')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('tr_member_laboratorium_id_kembali')->references('id')->on('tr_member_laboratorium')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_bon_alat');
    }
};