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
        Schema::create('tr_usulan_kebutuhan_detail', function (Blueprint $table) {
            // #1 - id: BIGINT(20) UNSIGNED
            $table->id(); 

            // #2 - keb_kel: TINYINT(3) UNSIGNED
            $table->unsignedTinyInteger('keb_kel'); 

            // #3 - total_keb: INT(10) UNSIGNED
            $table->unsignedInteger('total_keb'); 

            // #4 - keb_acc: INT(10) UNSIGNED (Boleh Null)
            $table->unsignedInteger('keb_acc')->nullable(); 

            // #5 - tm_barang_id: INT(10) UNSIGNED (FK ke tabel barang)
            $table->unsignedInteger('tm_barang_id'); 

            // #6 - td_satuan_id: INT(10) UNSIGNED (FK ke tabel satuan)
            $table->unsignedInteger('td_satuan_id'); 

            // #7 & #8 - created_at & updated_at
            $table->timestamps(); 

            // #9 - tr_usulan_kebutuhan_id: HARUS INT(10) UNSIGNED 
            // Karena tabel induk (tr_usulan_kebutuhan) memakai increments('id')
          // ✅ Benar - BIGINT sesuai backup
            $table->unsignedBigInteger('tr_usulan_kebutuhan_id');
            // #10 - keterangan: VARCHAR(128)
            $table->string('keterangan', 128)->nullable(); 

            // #11 - status: TINYINT(3)
            $table->tinyInteger('status')->nullable(); 

            // #12 - user_id: BIGINT(20) UNSIGNED
            $table->unsignedBigInteger('user_id')->nullable();

            // --- Definisi Foreign Keys ---

            // Relasi ke tabel barang
            $table->foreign('tm_barang_id')
                  ->references('id')->on('tm_barang');

            // Relasi ke tabel satuan
            $table->foreign('td_satuan_id')
                  ->references('id')->on('td_satuan');

            // Relasi ke tabel induk usulan kebutuhan (Penyebab error 3780 sebelumnya)
           $table->foreign('tr_usulan_kebutuhan_id', 'fk_detail_usulan_kebutuhan')
          ->references('id')
          ->on('tr_usulan_kebutuhan')
          ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_usulan_kebutuhan_detail');
    }
};