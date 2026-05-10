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
        Schema::create('tr_kaprodi', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT
            $table->smallIncrements('id');

            // #2 - tm_program_s...: SMALLINT(5), UNSIGNED, NOT NULL (FK)
            $table->unsignedSmallInteger('tm_program_studi_id');

            // #3 - tm_staff_id: INT(10), UNSIGNED, NOT NULL (FK)
            $table->unsignedInteger('tm_staff_id');

            // #4 - is_aktif: TINYINT(1), Default '1'
            $table->tinyInteger('is_aktif')->default(1);

            // #5 & #6 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // --- Definisi Foreign Key sesuai simbol kunci & relasi biru di gambar ---
            $table->foreign('tm_program_studi_id')->references('id')->on('tm_program_studi')
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
        Schema::dropIfExists('tr_kaprodi');
    }
};