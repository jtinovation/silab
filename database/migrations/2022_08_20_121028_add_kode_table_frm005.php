<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addKodeTableFrm005 extends Migration
{
    public function up()
    {
        Schema::table('tm_laboratorium', function (Blueprint $table) {
            $table->string('kode',32);
        });

        Schema::table('tr_barang_laboratorium', function (Blueprint $table) {
            $table->string('kode',32);
        });

        Schema::table('tr_member_laboratorium', function (Blueprint $table) {
            $table->string('kode',32);
        });

        Schema::table('tr_kartu_stok', function (Blueprint $table) {
            $table->string('kode',32);
        });

        Schema::table('tr_kesiapan_praktek', function (Blueprint $table) {
            $table->string('kode',32);
        });

        Schema::table('td_kesiapan_praktek_detail', function (Blueprint $table) {
            $table->string('kode',32);
        });

        Schema::table('tr_penggantian_praktek', function (Blueprint $table) {
            $table->string('kode',32);
        });
    }

    public function down()
    {
        Schema::table('tr_penggantian_praktek', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('td_kesiapan_praktek_detail', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('tr_kesiapan_praktek', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('tr_kartu_stok', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('tr_member_laboratorium', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('tr_barang_laboratorium', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('tm_laboratorium', function (Blueprint $table) {
            $table->dropColumn('kode');
        });
    }
}
