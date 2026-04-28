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
            $table->id();
            $table->tinyInteger('keb_kel')->unsigned();
            $table->integer('total_keb')->unsigned();
            $table->integer('keb_acc')->unsigned()->nullable();
            $table->integer('tm_barang_id')->unsigned();
            $table->integer('td_satuan_id')->unsigned();
            $table->timestamps();
            $table->bigInteger('tr_usulan_kebutuhan_id')->unsigned();
            $table->string('keterangan', 128)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->bigInteger('user_id')->nullable();
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