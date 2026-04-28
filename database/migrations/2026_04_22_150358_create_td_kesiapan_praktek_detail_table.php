<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('td_kesiapan_praktek_detail', function (Blueprint $table) {
           $table->id(); 
            $table->integer('tr_barang_laboratorium_id')->unsigned();
            $table->integer('tr_kesiapan_praktek_id')->unsigned();
            $table->integer('jumlah')->unsigned();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->string('kode')->nullable();
            $table->integer('tr_kartu_stok_id')->unsigned()->nullable();
            $table->integer('td_satuan_id')->unsigned();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('td_kesiapan_praktek_detail');
    }
};