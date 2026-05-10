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
        Schema::create('tr_kesiapan_praktek', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - kode: VARCHAR(32), NOT NULL
            $table->string('kode', 32);

            // #3 - tr_matakuliah_kurikulum_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tr_matakuliah_kurikulum_id')->nullable();

            // #4 - tr_matakuliah_dosen_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tr_matakuliah_dosen_id')->nullable();

            // #5 - tm_staff_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tm_staff_id')->nullable();

            // #6 - rekomendasi: TINYINT(3), UNSIGNED, Allow Null
            $table->unsignedTinyInteger('rekomendasi')->nullable();

            // #7 - tr_member_laboratorium_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id')->nullable();

            // #8 - tm_minggu_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_minggu_id')->nullable();

            // #9 - tanggal: DATE, Allow Null
            $table->date('tanggal')->nullable();

            // #10 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #11 - tm_laboratorium_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id')->nullable();

            // --- Definisi Foreign Key sesuai simbol kunci & relasi di gambar ---
            
            $table->foreign('tr_matakuliah_kurikulum_id', 'fk_kesiapan_kurikulum')
                  ->references('id')->on('tr_matakuliah_kurikulum')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tr_matakuliah_dosen_id', 'fk_kesiapan_dosen')
                  ->references('id')->on('tr_matakuliah_dosen')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_staff_id', 'fk_kesiapan_staff')
                  ->references('id')->on('tm_staff')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tr_member_laboratorium_id', 'fk_kesiapan_member')
                  ->references('id')->on('tr_member_laboratorium')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_minggu_id', 'fk_kesiapan_minggu')
                  ->references('id')->on('tm_minggu')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_laboratorium_id', 'fk_kesiapan_lab')
                  ->references('id')->on('tm_laboratorium')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_kesiapan_praktek');
    }
};