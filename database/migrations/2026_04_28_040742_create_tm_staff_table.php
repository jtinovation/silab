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
        Schema::create('tm_staff', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - kode: VARCHAR(32), Allow Null
            $table->string('kode', 32)->nullable();

            // #3 - nama: VARCHAR(64), NOT NULL
            $table->string('nama', 64);

            // #4 - email: VARCHAR(64), Allow Null
            $table->string('email', 64)->nullable();

            // #5 - no_hp: VARCHAR(32), Allow Null
            $table->string('no_hp', 32)->nullable();

            // #6 - foto: VARCHAR(255), Allow Null
            $table->string('foto', 255)->nullable();

            // #7 - is_aktif: TINYINT(1), Allow Null
            $table->tinyInteger('is_aktif')->nullable();

            // #8 & #9 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #10 - tm_status_kepegawaian_id: TINYINT(3), UNSIGNED, Allow Null (FK)
            $table->unsignedTinyInteger('tm_status_kepegawaian_id')->nullable();

            // --- Definisi Foreign Key sesuai ikon kunci hijau di gambar ---
            $table->foreign('tm_status_kepegawaian_id', 'fk_staff_status_kepegawaian')
                  ->references('id')->on('tm_status_kepegawaian')
                  ->onUpdate('cascade')->onDelete('set null');

            // Set collation table agar sesuai dengan skema di gambar (utf8mb4_unicode_ci)
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_staff');
    }
};