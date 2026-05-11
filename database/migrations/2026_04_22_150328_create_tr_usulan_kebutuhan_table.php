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
                    Schema::create('tr_usulan_kebutuhan', function (Blueprint $table) {
                    // Menghasilkan INT(10) UNSIGNED
                    $table->bigIncrements('id');
                    // ... kolom lainnya
            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - acara_praktek: VARCHAR(255), NOT NULL
            $table->string('acara_praktek', 255);

            // #4 - jml_kel: TINYINT(3), UNSIGNED, NOT NULL
            $table->unsignedTinyInteger('jml_kel');

            // #5 - keterangan: VARCHAR(255), Allow Null
            $table->string('keterangan', 255)->nullable();

            // #6 - status: TINYINT(3), UNSIGNED, NOT NULL
            $table->unsignedTinyInteger('status');

            // #7 - tm_minggu_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_minggu_id')->nullable();

            // #8 - user_id: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('user_id')->nullable();

            // #9 - tr_matakuliah_dosen_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tr_matakuliah_dosen_id')->nullable();

            // #10 & #11 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #12 - tanggal: DATE, Allow Null
            $table->date('tanggal')->nullable();

            // #13 - jml_gol: TINYINT(3), UNSIGNED, NOT NULL
            $table->unsignedTinyInteger('jml_gol');

            // #14 - tm_laboratorium_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id')->nullable();

            // --- Definisi Foreign Key sesuai ikon kunci hijau di gambar ---

            $table->foreign('tm_minggu_id', 'fk_usulan_minggu')
                  ->references('id')->on('tm_minggu')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('user_id', 'fk_usulan_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tr_matakuliah_dosen_id', 'fk_usulan_mk_dosen')
                  ->references('id')->on('tr_matakuliah_dosen')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_laboratorium_id', 'fk_usulan_lab')
                  ->references('id')->on('tm_laboratorium')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_usulan_kebutuhan');
    }
};