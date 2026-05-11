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
        Schema::create('td_hilang_rusak_detail', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, AUTO_INCREMENT (Kunci Kuning)
            $table->id();

            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - tr_barang_lab_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_barang_lab_id');

            // #4 - tr_hilang_rusak_id: INT(10), UNSIGNED (Kunci Hijau + Relasi)
            $table->unsignedInteger('tr_hilang_rusak_id');

            // #6 - jumlah_hilang_rusak: INT(10), UNSIGNED
            $table->unsignedInteger('jumlah_hilang_rusak');

            // #7 - status: TINYINT(3), UNSIGNED, Allow Null, Default '0'
            $table->tinyInteger('status')->unsigned()->nullable()->default(0);

            // #5 & #8 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // Definisi Foreign Key sesuai simbol relasi di gambar
            $table->foreign('tr_barang_lab_id')
                  ->references('id')
                  ->on('tr_barang_laboratorium') // Pastikan nama tabel referensinya sesuai
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('tr_hilang_rusak_id')
                  ->references('id')
                  ->on('tr_hilang_rusak') // Pastikan nama tabel referensinya sesuai
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_hilang_rusak_detail');
    }
};