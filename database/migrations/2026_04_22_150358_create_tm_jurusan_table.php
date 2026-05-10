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
        Schema::create('tm_jurusan', function (Blueprint $table) {
            // #1 - id: TINYINT(3), UNSIGNED, AUTO_INCREMENT
            $table->tinyIncrements('id');

            // #2 - kode: VARCHAR(8), Allow Null
            $table->string('kode', 8)->nullable();

            // #3 - jurusan: VARCHAR(64), NOT NULL
            $table->string('jurusan', 64);

            // #4 - user_id: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('user_id')->nullable();

            // #5 & #6 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // --- Definisi Foreign Key sesuai simbol relasi di gambar ---
            $table->foreign('user_id', 'fk_tm_jurusan_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_jurusan');
    }
};