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
        Schema::create('tr_member_laboratorium', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT
            $table->smallIncrements('id');

            // #2 - tm_laboratorium_id: SMALLINT(5), UNSIGNED, NOT NULL (FK)
            $table->unsignedSmallInteger('tm_laboratorium_id');

            // #3 - tm_staff_id: INT(10), UNSIGNED, NOT NULL (FK)
            $table->unsignedInteger('tm_staff_id');

            // #4 - is_kalab: TINYINT(1), Default '0'
            $table->tinyInteger('is_kalab')->default(0);

            // #5 - is_aktif: TINYINT(1), Default '1'
            $table->tinyInteger('is_aktif')->default(1);

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #8 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // --- Definisi Foreign Key sesuai ikon kunci hijau di gambar ---
            $table->foreign('tm_laboratorium_id', 'fk_member_lab')
                  ->references('id')->on('tm_laboratorium')
                  ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('tm_staff_id', 'fk_member_staff')
                  ->references('id')->on('tm_staff')
                  ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_member_laboratorium');
    }
};