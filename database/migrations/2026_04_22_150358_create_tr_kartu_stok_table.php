<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tr_kartu_stok', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->integer('tr_barang_laboratorium_id')->unsigned();
            $table->tinyInteger('is_stok_in');
            $table->integer('qty')->unsigned()->default(0);
            $table->integer('stok')->unsigned();
            $table->smallInteger('tr_member_laboratorium_id')->unsigned()->nullable();
            $table->bigInteger('tr_usulan_kebutuhan_detail_id')->unsigned()->nullable();
            $table->timestamps();
            $table->string('kode', 32)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->string('keterangan_sys', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_kartu_stok');
    }
};