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
        Schema::create('tm_satuan', function (Blueprint $table) {
            // #1 - id: SMALLINT(5), UNSIGNED, AUTO_INCREMENT, PRIMARY KEY
            $table->smallIncrements('id');

            // #2 - satuan: VARCHAR(64), NOT NULL (Allow Null tidak dicentang), No default
            $table->string('satuan', 64)->collation('utf8mb4_unicode_ci');

            // #3 - user_id: BIGINT(20), UNSIGNED, Allow Null
            // Menggunakan unsignedBigInteger agar tidak otomatis menambah constraint FK
            $table->unsignedBigInteger('user_id')->nullable();

            // #4 & #5 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Foreign key index untuk user_id (opsional, sesuaikan dengan kebutuhan)
            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_satuan');
    }
};