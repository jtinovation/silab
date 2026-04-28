<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tm_minggu', function (Blueprint $table) {
            $table->smallInteger('id')->unsigned()->autoIncrement();
            $table->tinyInteger('minggu_ke')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('tm_tahun_ajaran_id')->unsigned();
            $table->timestamps();
            $table->string('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tm_minggu');
    }
};