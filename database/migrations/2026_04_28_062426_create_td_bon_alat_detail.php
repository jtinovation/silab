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
        Schema::create('td_bon_alat_detail', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id'); 

            // #2 - kode: VARCHAR(32), NULL
            $table->string('kode', 32)->nullable(); 

            // #3 - jumlah: INT(10), UNSIGNED
            $table->unsignedInteger('jumlah'); 

            // #4 - tr_bon_alat_id: INT(10), UNSIGNED (FK)
            $table->unsignedInteger('tr_bon_alat_id'); 

            // #5 - tr_barang_laboratorium_id: INT(10), UNSIGNED (FK)
            $table->unsignedInteger('tr_barang_laboratorium_id'); 

            // #6 - tr_kartu_stok_id: INT(10), UNSIGNED, NULL (FK)
            $table->unsignedInteger('tr_kartu_stok_id')->nullable(); 

            // #7 - tr_kartu_stok_item_id: INT(10), UNSIGNED, NULL
            $table->unsignedInteger('tr_kartu_stok_item_id')->nullable(); 

            // #8 & #9 - created_at & updated_at: TIMESTAMP, NULL
            $table->timestamps(); 

            // #10 - jumlah_kembali: SMALLINT(5), UNSIGNED, NULL
            $table->unsignedSmallInteger('jumlah_kembali')->nullable(); 

            // #11 - keterangan: VARCHAR(255), NULL
            $table->string('keterangan', 255)->nullable(); 

            // #12 - status: TINYINT(3), UNSIGNED, NULL
            $table->unsignedTinyInteger('status')->nullable()->comment('0 => Tidak Lengkap...');

            // --- Definisi Foreign Keys sesuai indikator kunci hijau di gambar ---
            $table->foreign('tr_bon_alat_id')->references('id')->on('tr_bon_alat')->onDelete('cascade');
            $table->foreign('tr_barang_laboratorium_id', 'fk_detail_barang_lab')->references('id')->on('tr_barang_laboratorium');
            $table->foreign('tr_kartu_stok_id')->references('id')->on('tr_kartu_stok')->onDelete('set null');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_bon_alat_detail');
    }
};