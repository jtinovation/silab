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
        Schema::create('td_ijin_penggunaan_lbs_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->integer('jumlah');
            $table->integer('tr_ijin_penggunaan_lbs_id');
            $table->integer('tr_barang_laboratorium_id');
            $table->integer('tr_kartu_stok_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_ijin_penggunaan_lbs_detail');
    }
};
