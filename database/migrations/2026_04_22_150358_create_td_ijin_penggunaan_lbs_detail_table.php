<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('td_ijin_penggunaan_lbs_detail', function (Blueprint $table) {
            $table->bigId('id');
            $table->string('kode', 32)->nullable();
            $table->integer('jumlah')->unsigned();
            $table->integer('tr_ijin_penggunaan_lbs_id')->unsigned();
            $table->integer('tr_barang_laboratorium_id')->unsigned();
            $table->integer('tr_kartu_stok_id')->unsigned()->nullable();
            $table->timestamps();
            $table->string('keterangan', 255)->nullable();
            $table->integer('td_satuan_id')->unsigned();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('td_ijin_penggunaan_lbs_detail');
    }
};