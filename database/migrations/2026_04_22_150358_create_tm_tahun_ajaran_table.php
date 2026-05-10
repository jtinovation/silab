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
        Schema::create('tm_tahun_ajaran', function (Blueprint $table) {
            // #1 - id: TINYINT(3), UNSIGNED, AUTO_INCREMENT, PRIMARY KEY
            $table->tinyIncrements('id');

            // #2 - tahun_ajaran: VARCHAR(10), Allow Null
            $table->string('tahun_ajaran', 10)->nullable();

            // #3 & #4 - created_at & updated_at: TIMESTAMP, Allow Null
            // Didefinisikan manual agar urutan kolom tepat setelah tahun_ajaran
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // #5 - is_genap: TINYINT(3), UNSIGNED, Allow Null
            $table->unsignedTinyInteger('is_genap')->nullable();

            // #6 - is_aktif: TINYINT(3), (Berdasarkan gambar: SIGNED), Allow Null
            $table->tinyInteger('is_aktif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_tahun_ajaran');
    }
};