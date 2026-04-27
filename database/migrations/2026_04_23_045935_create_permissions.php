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
        Schema::create('permissions', function (Blueprint $table) {
            // `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->id(); 

            // `name` VARCHAR(191) NOT NULL
            $table->string('name', 191);

            // `guard_name` VARCHAR(191) NOT NULL
            $table->string('guard_name', 191);

            // `created_at` & `updated_at` TIMESTAMP NULL DEFAULT NULL
            $table->timestamps();

            // UNIQUE INDEX `permissions_name_guard_name_unique`
            $table->unique(['name', 'guard_name'], 'permissions_name_guard_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};