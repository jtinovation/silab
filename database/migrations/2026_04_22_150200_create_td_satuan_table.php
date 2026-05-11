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
        Schema::create('td_satuan', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT (Kunci Kuning)
            $table->increments('id');

            // #2 - qty: INT(10), UNSIGNED, Allow Null
            $table->unsignedInteger('qty')->nullable();

            // #3 - tm_satuan_id: SMALLINT(5), UNSIGNED, Allow Null (Kunci Hijau + Relasi)
            $table->unsignedSmallInteger('tm_satuan_id')->nullable();

            // #4 - tm_barang_id: INT(10), UNSIGNED, Allow Null (Kunci Hijau + Relasi)
            $table->unsignedInteger('tm_barang_id')->nullable();

            // #5 - user_id: BIGINT(20), UNSIGNED, Allow Null (Kunci Hijau + Relasi)
            $table->unsignedBigInteger('user_id')->nullable();

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---

            $table->foreign('tm_satuan_id', 'fk_td_satuan_tm_satuan')
                  ->references('id')->on('tm_satuan')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_barang_id', 'fk_td_satuan_tm_barang')
                  ->references('id')->on('tm_barang')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('user_id', 'fk_td_satuan_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_satuan');
    }
};