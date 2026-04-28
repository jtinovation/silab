<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('td_sisa_praktek', function (Blueprint $table) {
            $table->id(); // ✅
            $table->string('kode')->nullable();
            $table->integer('jumlah')->unsigned();
            $table->integer('tr_barang_laboratorium_id')->unsigned();
            $table->integer('tr_kartu_stok_id')->unsigned();
            $table->integer('tr_serma_hasil_praktek_id')->unsigned();
            $table->timestamps();
            $table->integer('td_satuan_id')->unsigned();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('td_sisa_praktek');
    }
};