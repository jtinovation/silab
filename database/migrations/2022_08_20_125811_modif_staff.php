<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifStaff extends Migration
{
    public function up()
    {
        Schema::create('tm_status_kepegawaian', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('status_kepegawaian', 32);
            $table->timestamps();
        });

        Schema::table('tm_staff', function (Blueprint $table) {
            $table->unsignedTinyInteger('tm_status_kepegawaian_id')->nullable();
            $table->foreign('tm_status_kepegawaian_id')->references('id')->on('tm_status_kepegawaian')->onDelete('SET NULL');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_staff', function (Blueprint $table) {
            $table->dropColumn('tm_status_kepegawaian_id');
        });

    }
}
