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
            // #1 - id: TINYINT(3), UNSIGNED, NOT NULL, AUTO_INCREMENT, PRIMARY KEY
            $table->tinyIncrements('id');

            // #2 - status_kepegawaian: VARCHAR(32), NOT NULL, No default
            $table->string('status_kepegawaian', 32)->collation('utf8mb4_unicode_ci');

            // #3 - created_at: TIMESTAMP, Allow Null, Default NULL
            $table->timestamp('created_at')->nullable();

            // #4 - updated_at: TIMESTAMP, Allow Null, Default NULL
            $table->timestamp('updated_at')->nullable();
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