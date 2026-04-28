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
            // #1 - id: INT(10), UNSIGNED, NOT NULL, AUTO_INCREMENT, PRIMARY KEY
            $table->increments('id');

            // #2 - kode: VARCHAR(32), Allow Null, Default NULL
            $table->string('kode', 32)->nullable()->collation('utf8mb4_unicode_ci');

            // #3 - nama: VARCHAR(64), NOT NULL, No default
            $table->string('nama', 64)->collation('utf8mb4_unicode_ci');

            // #4 - email: VARCHAR(64), Allow Null, Default NULL
            $table->string('email', 64)->nullable()->collation('utf8mb4_unicode_ci');

            // #5 - no_hp: VARCHAR(32), Allow Null, Default NULL
            $table->string('no_hp', 32)->nullable()->collation('utf8mb4_unicode_ci');

            // #6 - foto: VARCHAR(255), Allow Null, Default NULL
            $table->string('foto', 255)->nullable()->collation('utf8mb4_unicode_ci');

            // #7 - is_aktif: TINYINT(1), NOT UNSIGNED, Allow Null, Default NULL
            $table->tinyInteger('is_aktif')->nullable();

            // #8 & #9 - created_at & updated_at: TIMESTAMP, Allow Null, Default NULL
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // #10 - tm_status_kepegawaian_id: TINYINT(3), UNSIGNED, Allow Null, Default NULL (FK)
            $table->unsignedTinyInteger('tm_status_kepegawaian_id')->nullable();
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