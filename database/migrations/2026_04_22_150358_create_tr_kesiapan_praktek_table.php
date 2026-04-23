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
        Schema::create('tr_kesiapan_praktek', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tr_matakuliah_dosen_id');
            $table->integer('tm_staff_id');
            $table->integer('rekomendasi');
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
        Schema::dropIfExists('tr_kesiapan_praktek');
    }
};
