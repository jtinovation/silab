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
        Schema::create('td_hasil_praktek', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, AUTO_INCREMENT (Kunci Kuning)
            $table->id();

            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - jumlah: INT(10), UNSIGNED, NOT NULL
            $table->unsignedInteger('jumlah');

            // #4 - tr_barang_lab_id: INT(10), UNSIGNED, NOT NULL
            $table->unsignedInteger('tr_barang_lab_id');

            // #5 - tr_serma_hasil_id: INT(10), UNSIGNED, Allow Null (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_serma_hasil_id')->nullable();

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #8 - tr_kartu_stok_id: INT(10), UNSIGNED, Allow Null
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();

            // Penyiapan Foreign Key untuk baris #5 sesuai gambar
            $table->foreign('tr_serma_hasil_id')
                  ->references('id')
                  ->on('tr_serma_hasil') // Asumsi nama tabel referensinya
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_hasil_praktek');
    }
};