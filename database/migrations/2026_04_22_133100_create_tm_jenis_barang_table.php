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
        Schema::create('tm_jenis_barang', function (Blueprint $table) {
            // #1 - id: TINYINT(3), UNSIGNED, AUTO_INCREMENT
            $table->tinyIncrements('id');

            // #2 - jenis_barang: VARCHAR(32), Allow Null
            $table->string('jenis_barang', 32)->nullable();

            // #3 & #4 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_jenis_barang');
    }
};