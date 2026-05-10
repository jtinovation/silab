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
            // #1 - id: BIGINT(20), UNSIGNED, AUTO_INCREMENT
            $table->id();

            // #2 - name: VARCHAR(191), NOT NULL
            $table->string('name', 191);

            // #3 - guard_name: VARCHAR(191), NOT NULL
            $table->string('guard_name', 191);

            // #4 & #5 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // UNIQUE INDEX roles_name_guard_name_unique sesuai ikon kunci merah
            $table->unique(['name', 'guard_name'], 'roles_name_guard_name_unique');
            
            // Memastikan engine menggunakan InnoDB untuk mendukung integritas data
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