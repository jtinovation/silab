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
        Schema::create('tm_barang', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - nama_barang: VARCHAR(64), No default
            $table->string('nama_barang', 64);

            // #3 - spesifikasi: VARCHAR(255), Allow Null
            $table->string('spesifikasi', 255)->nullable();

            // #4 - keterangan: VARCHAR(255), Allow Null
            $table->string('keterangan', 255)->nullable();

            // #5 - user_id: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('user_id')->nullable();

            // #6 - tm_satuan_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_satuan_id')->nullable();

            // #7 - tm_jenis_barang_id: TINYINT(3), UNSIGNED, Allow Null (FK)
            $table->unsignedTinyInteger('tm_jenis_barang_id')->nullable();

            // #8 & #9 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #10 - qty: INT(10), UNSIGNED, Allow Null
            $table->unsignedInteger('qty')->nullable();

            // #11 - kode_barang: VARCHAR(32), Allow Null
            $table->string('kode_barang', 32)->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---

            $table->foreign('user_id', 'fk_tm_barang_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_satuan_id', 'fk_tm_barang_satuan')
                  ->references('id')->on('tm_satuan')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_jenis_barang_id', 'fk_tm_barang_jenis')
                  ->references('id')->on('tm_jenis_barang')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_barang');
    }
};