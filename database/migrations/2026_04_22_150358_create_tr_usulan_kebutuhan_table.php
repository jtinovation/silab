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
        Schema::create('tr_usulan_kebutuhan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('acara_praktek');
            $table->integer('keb_kel');
            $table->integer('jml_kel');
            $table->string('keterangan');
            $table->integer('status');
            $table->integer('td_satuan_id')->nullable();
            $table->integer('tm_minggu_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('tm_barang_id')->nullable();
            $table->integer('tr_matakuliah_dosen_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('tm_laboratorium_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_usulan_kebutuhan');
    }
};
