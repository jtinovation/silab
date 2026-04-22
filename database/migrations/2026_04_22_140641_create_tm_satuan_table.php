<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tm_satuan', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('satuan', 64)->collation('utf8mb4_unicode_ci');
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('no action')
                  ->onDelete('set null');
            $table->timestamps();
        });

        // Sekarang DB::statement akan dikenali
        DB::statement("ALTER TABLE tm_satuan AUTO_INCREMENT = 10;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_satuan');
    }
};