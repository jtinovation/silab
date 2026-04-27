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
            // Kolom ID Referensi
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            // Menetapkan Composite Primary Key
            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_primary');

            // Foreign Key ke tabel permissions
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            // Foreign Key ke tabel roles
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            // Catatan: Index untuk role_id otomatis terbuat melalui foreign key di beberapa database,
            // namun kita pastikan engine menggunakan InnoDB sesuai permintaan.
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