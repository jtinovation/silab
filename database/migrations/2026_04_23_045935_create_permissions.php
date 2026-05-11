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
        Schema::create('permissions', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, AUTO_INCREMENT
            $table->id(); 

            // #2 - name: VARCHAR(125), NOT NULL
            // Catatan: Gambar menunjukkan Length/Set 125
            $table->string('name', 125);

            // #3 - guard_name: VARCHAR(125), NOT NULL
            // Catatan: Gambar menunjukkan Length/Set 125
            $table->string('guard_name', 125);

            // #4 & #5 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // Menambahkan Unique Index sesuai dengan tab 'Indexes' di HeidiSQL
            // Biasanya dinamai 'permissions_name_guard_name_unique'
            $table->unique(['name', 'guard_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};