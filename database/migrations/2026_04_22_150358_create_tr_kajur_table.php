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
        Schema::create('tr_kajur', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT
            $table->smallIncrements('id');

            // #2 - tm_jurusan_id: TINYINT(3), UNSIGNED, NOT NULL (FK)
            $table->unsignedTinyInteger('tm_jurusan_id');

            // #3 - tm_staff_id: INT(10), UNSIGNED, NOT NULL (FK)
            $table->unsignedInteger('tm_staff_id');

            // #4 - is_aktif: TINYINT(1), Default '1'
            $table->tinyInteger('is_aktif')->default(1);

            // #5 & #6 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // --- Definisi Foreign Key sesuai ikon kunci hijau di gambar ---
            $table->foreign('tm_jurusan_id')->references('id')->on('tm_jurusan')
                  ->onUpdate('cascade')->onDelete('restrict');
            
            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')
                  ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_kajur');
    }
};