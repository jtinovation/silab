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
        Schema::create('tr_serma_hasil_sisa_praktek', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->integer('tr_matakuliah_dosen_id');
            $table->integer('tr_member_laboratorium_id');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_serma_hasil_sisa_praktek');
    }
};
