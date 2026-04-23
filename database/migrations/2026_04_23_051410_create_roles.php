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
        Schema::create('roles', function (Blueprint $table) {
            // `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT
            $table->id();

            // `name` VARCHAR(191) NOT NULL
            $table->string('name', 191);

            // `guard_name` VARCHAR(191) NOT NULL
            $table->string('guard_name', 191);

            // `created_at` & `updated_at` TIMESTAMP NULL DEFAULT NULL
            $table->timestamps();

            // UNIQUE INDEX `roles_name_guard_name_unique` (`name`, `guard_name`)
            $table->unique(['name', 'guard_name'], 'roles_name_guard_name_unique');
            
            // Engine InnoDB
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};