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
        Schema::create('tr_barang_laboratorium', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - stok: INT(10), UNSIGNED, NOT NULL
            $table->unsignedInteger('stok');

            // #3 - tm_laboratorium_id: SMALLINT(5), UNSIGNED, NOT NULL (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id');

            // #4 - tm_barang_id: INT(10), UNSIGNED, NOT NULL (FK)
            $table->unsignedInteger('tm_barang_id');

            // #5 - is_aktif: TINYINT(3), UNSIGNED, Default '1'
            $table->unsignedTinyInteger('is_aktif')->default(1);

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #8 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #9 - keterangan: VARCHAR(255), Allow Null
            $table->string('keterangan', 255)->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('tm_laboratorium_id', 'fk_tr_barang_lab_laboratorium')
                  ->references('id')->on('tm_laboratorium')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('tm_barang_id', 'fk_tr_barang_lab_barang')
                  ->references('id')->on('tm_barang')
                  ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_barang_laboratorium');
    }
};