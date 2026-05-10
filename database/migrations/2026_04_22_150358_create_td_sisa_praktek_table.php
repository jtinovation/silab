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
        Schema::create('td_sisa_praktek', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, AUTO_INCREMENT
            $table->id(); 

            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - jumlah: INT(10), UNSIGNED, NOT NULL
            $table->unsignedInteger('jumlah');

            // #4 - tr_barang_lab_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_barang_lab_id');

            // #5 - tr_kartu_stok_id: INT(10), UNSIGNED, Allow Null (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();

            // #6 - tr_serma_hasil_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_serma_hasil_id');

            // #7 & #8 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #9 - td_satuan_id: INT(10), UNSIGNED, NOT NULL
            $table->unsignedInteger('td_satuan_id');

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---

            $table->foreign('tr_barang_lab_id', 'fk_sisa_praktek_barang')
                  ->references('id')->on('tr_barang_lab')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('tr_kartu_stok_id', 'fk_sisa_praktek_stok')
                  ->references('id')->on('tr_kartu_stok')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tr_serma_hasil_id', 'fk_sisa_praktek_hasil')
                  ->references('id')->on('tr_serma_hasil')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_sisa_praktek');
    }
};