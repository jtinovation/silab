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
        Schema::create('model_has_permissions', function (Blueprint $table) {
            // #1 - permission_id: BIGINT(20), UNSIGNED, NOT NULL
            $table->unsignedBigInteger('permission_id');

            // #2 - model_type: VARCHAR(191), NOT NULL
            $table->string('model_type', 191);

            // #3 - model_id: BIGINT(20), UNSIGNED, NOT NULL
            $table->unsignedBigInteger('model_id');

            // Index untuk performa pencarian model polimorfik
            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            // Composite Primary Key (Ikon kunci kuning pada ketiga kolom di gambar)
            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_permission_primary');

            // Foreign Key ke tabel permissions (Ikon kunci biru pada permission_id)
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');
            
            // Konfigurasi Engine dan Charset sesuai skema standar
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_permissions');
    }
};