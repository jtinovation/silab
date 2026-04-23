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
        Schema::create('td_hilang_rusak_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->integer('tr_barang_laboratorium_id');
            $table->integer('tr_hilang_rusak_id');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_hilang_rusak_detail');
    }
};
