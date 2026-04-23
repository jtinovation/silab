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
        Schema::create('tr_member_laboratorium', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tm_laboratorium_id');
            $table->integer('tm_staff_id');
            $table->boolean('is_kalab')->default(false);
            $table->boolean('is_aktif')->default(true);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_member_laboratorium');
    }
};
