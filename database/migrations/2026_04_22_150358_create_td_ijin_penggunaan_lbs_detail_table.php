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
        Schema::create('td_ijin_penggunaan_lbs_detail', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, AUTO_INCREMENT (Kunci Kuning)
            $table->id();

            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - jumlah: INT(10), UNSIGNED, NOT NULL
            $table->unsignedInteger('jumlah');

            // #4 - tr_ijin_penggunaan_lbs_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_ijin_penggunaan_lbs_id');

            // #5 - tr_barang_lab_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            // Catatan: Di gambar tertulis tr_barang_lab..., sesuaikan dengan nama kolom asli
            $table->unsignedInteger('tr_barang_lab_id');

            // #6 - tr_kartu_stok_id: INT(10), UNSIGNED, Allow Null (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();

            // #7 & #8 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #9 - keterangan: VARCHAR(255), Allow Null
            $table->string('keterangan', 255)->nullable();

            // #10 - td_satuan_id: INT(10), UNSIGNED, NOT NULL
            $table->unsignedInteger('td_satuan_id');

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---

            $table->foreign('tr_ijin_penggunaan_lbs_id', 'fk_ijin_lbs_detail_parent')
                  ->references('id')->on('tr_ijin_penggunaan_lbs')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('tr_barang_lab_id', 'fk_ijin_lbs_detail_barang')
                  ->references('id')->on('tr_barang_laboratorium')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('tr_kartu_stok_id', 'fk_ijin_lbs_detail_stok')
                  ->references('id')->on('tr_kartu_stok')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_ijin_penggunaan_lbs_detail');
    }
};