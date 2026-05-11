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
            // #1 - role_id: BIGINT(20), UNSIGNED, NOT NULL
            $table->unsignedBigInteger('role_id');

            // #2 - model_type: VARCHAR(191), NOT NULL
            $table->string('model_type', 191);

            // #3 - model_id: BIGINT(20), UNSIGNED, NOT NULL
            $table->unsignedBigInteger('model_id');

            // Menambahkan Index untuk performa query polimorfik
            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

            // Menetapkan Composite Primary Key (ditandai ikon kunci kuning pada ketiga kolom)
            $table->primary(['role_id', 'model_id', 'model_type'], 'model_has_roles_role_primary');

            // Foreign Key ke tabel roles (ditandai ikon kunci biru pada role_id)
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

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