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
        Schema::create('migrations', function (Blueprint $table) {
            // `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->increments('id'); 
            
            // `migration` VARCHAR(191) NOT NULL
            $table->string('migration', 191); 
            
            // `batch` INT NOT NULL
            $table->integer('batch');
            
            // Catatan: Engine InnoDB dan Charset utf8mb4 adalah default di Laravel modern
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('migrations');
    }
};