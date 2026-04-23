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
        Schema::create('tr_penggantian_praktek', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('jadwal_asli');
            $table->dateTime('jadwal_ganti');
            $table->string('acara_praktek');
            $table->integer('tr_kaprodi_id');
            $table->integer('tr_member_laboratorium_id');
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
        Schema::dropIfExists('tr_penggantian_praktek');
    }
};
