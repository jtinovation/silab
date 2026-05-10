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
        Schema::create('role_has_permissions', function (Blueprint $table) {
            // #1 - permission_id: BIGINT(20), UNSIGNED, NOT NULL (FK)
            $table->unsignedBigInteger('permission_id');

            // #2 - role_id: BIGINT(20), UNSIGNED, NOT NULL (FK)
            $table->unsignedBigInteger('role_id');

            // Menetapkan Composite Primary Key sesuai ikon kunci kuning di gambar
            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_primary');

            // --- Definisi Foreign Key ---
            // Berdasarkan ikon kunci biru yang menunjukkan relasi

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            // Menggunakan Engine InnoDB untuk mendukung Foreign Key
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
    }
};