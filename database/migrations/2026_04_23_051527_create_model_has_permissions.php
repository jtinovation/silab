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
            // Kolom Dasar
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type', 191);
            $table->unsignedBigInteger('model_id');

            // Index tambahan untuk performa pencarian model
            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            // Menetapkan Primary Key Gabungan (Composite Primary Key)
            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_permission_primary');

            // Relasi Foreign Key
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');
            
            // Opsional: Jika ingin memaksa engine InnoDB (biasanya sudah default)
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