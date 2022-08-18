<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetailUsulanKebutuhan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_usulan_kebutuhan', function (Blueprint $table) {
            $table->dropColumn('keb_kel');
            $table->dropForeign('tr_usulan_kebutuhan_tm_barang_id_foreign');
            $table->dropColumn('tm_barang_id');
            $table->dropForeign('tr_usulan_kebutuhan_td_satuan_id_foreign');
            $table->dropColumn('td_satuan_id');
        });

        Schema::create('tr_usulan_kebutuhan_detail', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedTinyInteger('keb_kel');
            $table->unsignedInteger('total_keb');
            $table->unsignedInteger('keb_acc');
            $table->unsignedInteger('tm_barang_id')->nullable();
            $table->unsignedInteger('td_satuan_id')->nullable();
            $table->timestamps();

            $table->foreign('tm_barang_id')->references('id')->on('tm_barang')->onDelete('SET NULL');
            $table->foreign('td_satuan_id')->references('id')->on('td_satuan')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_usulan_kebutuhan_detail');
        Schema::table('tr_usulan_kebutuhan', function (Blueprint $table) {
            $table->unsignedTinyInteger('keb_kel');
            $table->unsignedInteger('tm_barang_id')->nullable();
            $table->unsignedInteger('td_satuan_id')->nullable();

            $table->foreign('tm_barang_id')->references('id')->on('tm_barang')->onDelete('SET NULL');
            $table->foreign('td_satuan_id')->references('id')->on('td_satuan')->onDelete('SET NULL');

        });
    }
}
