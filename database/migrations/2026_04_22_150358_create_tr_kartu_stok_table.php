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
        Schema::create('tr_kartu_stok', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - tr_barang_lab...: INT(10), UNSIGNED, NOT NULL (FK)
            $table->unsignedInteger('tr_barang_laboratorium_id');

            // #3 - is_stok_in: TINYINT(1), NOT NULL
            $table->tinyInteger('is_stok_in');

            // #4 - qty: INT(10), UNSIGNED, Default '0'
            $table->integer('qty')->unsigned()->default(0);

            // #5 - stok: INT(10), UNSIGNED, NOT NULL
            $table->integer('stok')->unsigned();

            // #6 - tr_member_la...: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tr_member_laboratorium_id')->nullable();

            // #7 - tr_usulan_keb...: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('tr_usulan_kebutuhan_detail_id')->nullable();

            // #8 & #9 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #10 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #11 - keterangan: VARCHAR(255), Allow Null
            $table->string('keterangan', 255)->nullable();

            // #12 - keterangan_sys: VARCHAR(255), Allow Null
            $table->string('keterangan_sys', 255)->nullable();

            // --- Definisi Foreign Key berdasarkan ikon kunci hijau & relasi biru ---
            $table->foreign('tr_barang_laboratorium_id', 'fk_tr_kartu_stok_barang')
                  ->references('id')->on('tr_barang_laboratorium')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('tr_member_laboratorium_id', 'fk_tr_kartu_stok_member')
                  ->references('id')->on('tr_member_laboratorium')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tr_usulan_kebutuhan_detail_id', 'fk_tr_kartu_stok_usulan')
                  ->references('id')->on('tr_usulan_kebutuhan_detail')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_kartu_stok');
    }
};