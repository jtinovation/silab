<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->unsignedTinyInteger('is_aktif');
            $table->unsignedInteger('tm_staff_id')->nullable();
        });

        Schema::create('tm_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 32)->nullable();
            $table->string('nama', 64);
            $table->string('email', 64)->nullable();
            $table->string('no_hp', 32)->nullable();
            $table->string('foto', 255)->nullable();
            $table->boolean('is_aktif')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_aktif');
            $table->dropColumn('tm_staff_id');
        });

        Schema::dropIfExists('tm_staff');
    }
}
