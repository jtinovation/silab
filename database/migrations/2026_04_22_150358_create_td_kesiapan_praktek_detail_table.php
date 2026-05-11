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
        Schema::create('td_kesiapan_praktek_detail', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, AUTO_INCREMENT (Kunci Kuning)
            $table->id();

            // #2 - tr_barang_lab_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            // Catatan: Nama di gambar terpotong 'tr_barang_lab...', pastikan sesuai kolom asli
            $table->unsignedInteger('tr_barang_lab_id');

            // #3 - tr_kesiapan_praktek_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_kesiapan_praktek_id');

            // #4 - jumlah: INT(10), UNSIGNED, Default '0'
            $table->unsignedInteger('jumlah')->default(0);

            // #5 - keterangan: VARCHAR(255), Allow Null
            $table->string('keterangan', 255)->nullable();

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #8 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #9 - tr_kartu_stok_id: INT(10), UNSIGNED, Allow Null
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();

            // #10 - td_satuan_id: INT(10), UNSIGNED, Allow Null
            $table->unsignedInteger('td_satuan_id')->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---

            $table->foreign('tr_barang_lab_id', 'fk_kesiapan_detail_barang')
                  ->references('id')->on('tr_barang_laboratorium')
                  ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('tr_kesiapan_praktek_id', 'fk_kesiapan_detail_parent')
                  ->references('id')->on('tr_kesiapan_praktek')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_kesiapan_praktek_detail');
    }
};