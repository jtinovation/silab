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
        Schema::create('tm_status_kepegawaian', function (Blueprint $table) {
            // #1 - id: TINYINT(3), UNSIGNED, AUTO_INCREMENT, PRIMARY KEY
            $table->tinyIncrements('id');

            // #2 - status_kepegawaian: VARCHAR(32), NOT NULL
            $table->string('status_kepegawaian', 32);

            // #3 & #4 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // Opsional: Pengaturan engine dan collation global untuk tabel ini
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_status_kepegawaian');
    }
};