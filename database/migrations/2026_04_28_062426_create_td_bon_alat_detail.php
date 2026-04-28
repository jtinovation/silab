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
            // 1. id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->id(); 

            // 2. kode VARCHAR(32) NULL
            $table->string('kode', 32)->nullable(); 

            // 3. jumlah INT UNSIGNED (No Default)
            $table->integer('jumlah')->unsigned(); 

            // 4. tr_bon_alat_id INT UNSIGNED (Foreign Key)
            $table->integer('tr_bon_alat_id')->unsigned(); 

            // 5. tr_barang_laboratorium_id INT UNSIGNED
            // (Saya asumsikan nama lengkapnya berdasarkan konteks 'labo...')
            $table->integer('tr_barang_laboratorium_id')->unsigned(); 

            // 6. tr_kartu_stok_id INT UNSIGNED NULL
            $table->integer('tr_kartu_stok_id')->unsigned()->nullable(); 

            // 7. tr_kartu_stok_item_id INT UNSIGNED NULL
            // (Saya asumsikan nama lengkapnya berdasarkan konteks 'stok_i...')
            $table->integer('tr_kartu_stok_item_id')->unsigned()->nullable(); 

            // 8 & 9. created_at & updated_at TIMESTAMP NULL
            $table->timestamps(); 

            // 10. jumlah_kembali SMALLINT UNSIGNED NULL
            $table->smallInteger('jumlah_kembali')->unsigned()->nullable(); 

            // 11. keterangan VARCHAR(255) NULL
            $table->string('keterangan', 255)->nullable(); 

            // 12. status TINYINT UNSIGNED NULL dengan Comment
            $table->tinyInteger('status')->unsigned()->nullable()->comment('0 => Tidak Lengkap...');
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