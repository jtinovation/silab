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
            $table->increments('id');
            $table->integer('tr_barang_laboratorium_id');
            $table->boolean('is_stok_in');
            $table->integer('qty')->default(0);
            $table->integer('stok');
            $table->integer('tr_member_laboratorium_id')->nullable();
            $table->integer('tr_usulan_kebutuhan_detail_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('kode');
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
