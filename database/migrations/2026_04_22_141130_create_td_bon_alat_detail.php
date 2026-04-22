<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('td_bon_alat_detail', function (Blueprint $table) {
            // id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT
            $table->increments('id');

            $table->string('kode', 32)->nullable()->collation('utf8mb4_unicode_ci');
            $table->unsignedInteger('jumlah');

            // Foreign Key: tr_bon_alat_id
            $table->foreignId('tr_bon_alat_id')
                  ->constrained('tr_bon_alat')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            // Foreign Key: tr_barang_laboratorium_id
            $table->foreignId('tr_barang_laboratorium_id')
                  ->constrained('tr_barang_laboratorium')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            // Foreign Key: tr_kartu_stok_id (Nullable)
            $table->foreignId('tr_kartu_stok_id')
                  ->nullable()
                  ->constrained('tr_kartu_stok')
                  ->onUpdate('no action')
                  ->onDelete('cascade');

            // Kolom tr_kartu_stok_id_kembali (Manual, karena tidak ada constraint formal di SQL Anda)
            $table->unsignedInteger('tr_kartu_stok_id_kembali')->nullable();

            $table->timestamps();
            
            $table->smallInteger('jumlah_kembali')->unsigned()->nullable();
            $table->string('keterangan', 255)->nullable()->collation('utf8mb4_unicode_ci');
            
            // tinyInteger untuk status dengan komentar
            $table->tinyInteger('status')->unsigned()->nullable()->comment('0 => Tidak Lengkap, 1 => Lengkap');
        });

        // Set AUTO_INCREMENT mulai dari 46
        DB::statement("ALTER TABLE td_bon_alat_detail AUTO_INCREMENT = 46;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_bon_alat_detail');
    }
};