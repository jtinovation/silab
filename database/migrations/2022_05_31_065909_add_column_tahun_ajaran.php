<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTahunAjaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tm_semester', function($table) {
            $table->unsignedTinyInteger('tm_tahun_ajaran_id')->nullable();

            $table->foreign('tm_tahun_ajaran_id')
            ->references('id')->on('tm_tahun_ajaran')
            ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_semester', function (Blueprint $table) {
            $table->dropColumn('tm_tahun_ajaran_id');
        });

    }
}
