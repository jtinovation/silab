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
        Schema::create('tm_semester', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT
            $table->smallIncrements('id');

            // #2 - semester: TINYINT(3), UNSIGNED, NOT NULL
            $table->unsignedTinyInteger('semester');

            // #3 - is_genap: TINYINT(1), NOT NULL
            $table->tinyInteger('is_genap');

            // #4 - user_id: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('user_id')->nullable();

            // #5 & #6 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #7 - tm_tahun_ajaran_id: TINYINT(3), UNSIGNED, Allow Null (FK)
            $table->unsignedTinyInteger('tm_tahun_ajaran_id')->nullable();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('user_id', 'fk_tm_semester_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_tahun_ajaran_id', 'fk_tm_semester_tahun_ajaran')
                  ->references('id')->on('tm_tahun_ajaran')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_semester');
    }
};