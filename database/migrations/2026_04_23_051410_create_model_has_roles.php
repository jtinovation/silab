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
        Schema::create('model_has_roles', function (Blueprint $table) {
            // Kolom Role ID (Foreign Key)
            $table->unsignedBigInteger('role_id');
            
            // Kolom Morph (model_type dan model_id)
            $table->string('model_type', 191);
            $table->unsignedBigInteger('model_id');

            // Menambahkan Index sesuai permintaan SQL
            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

            // Membuat Composite Primary Key
            $table->primary(['role_id', 'model_id', 'model_type'], 'model_has_roles_role_primary');

            // Foreign Key Constraint ke tabel roles
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            
            // Opsional: Pengaturan Engine
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_roles');
    }
};