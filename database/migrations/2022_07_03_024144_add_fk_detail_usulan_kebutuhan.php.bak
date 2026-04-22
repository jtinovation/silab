<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkDetailUsulanKebutuhan extends Migration
{
    public function up()
    {
        Schema::table('tr_usulan_kebutuhan_detail', function (Blueprint $table) {
            $table->unsignedInteger('tr_usulan_kebutuhan_id');

            $table->foreign('tr_usulan_kebutuhan_id')->references('id')->on('tr_usulan_kebutuhan')->onDelete('CASCADE');

        });
    }

    public function down()
    {
        //
    }

}
