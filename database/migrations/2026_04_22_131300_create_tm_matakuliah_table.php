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
        Schema::create('tm_matakuliah', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT
            $table->smallIncrements('id');

            // #2 - kode: VARCHAR(12), Allow Null
            $table->string('kode', 12)->nullable();

            // #3 - matakuliah: VARCHAR(64), NOT NULL
            $table->string('matakuliah', 64);

            // #4 - is_aktif: TINYINT(1), NOT NULL
            $table->tinyInteger('is_aktif');

            // #5 - user_id: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('user_id')->nullable();

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('user_id', 'fk_tm_matakuliah_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_matakuliah');
    }
};