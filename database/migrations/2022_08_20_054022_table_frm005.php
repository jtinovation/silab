<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableFrm005 extends Migration
{
    public function up()
    {
        Schema::create('tr_kajur', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedTinyInteger('tm_jurusan_id');
            $table->unsignedInteger('tm_staff_id');
            $table->boolean('is_aktif')->default(1);
            $table->timestamps();

            $table->foreign('tm_jurusan_id')->references('id')->on('tm_jurusan')->onDelete('CASCADE');
            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onDelete('CASCADE');
        });

        Schema::create('tr_kaprodi', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('tm_program_studi_id');
            $table->unsignedInteger('tm_staff_id');
            $table->boolean('is_aktif')->default(1);
            $table->timestamps();

            $table->foreign('tm_program_studi_id')->references('id')->on('tm_program_studi')->onDelete('CASCADE');
            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onDelete('CASCADE');
        });

        Schema::create('tm_laboratorium', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('laboratorium', 64);
            $table->unsignedTinyInteger('tm_jurusan_id');
            $table->boolean('is_aktif')->default(1);
            $table->timestamps();

            $table->foreign('tm_jurusan_id')->references('id')->on('tm_jurusan')->onDelete('CASCADE');
        });

        Schema::create('tr_barang_laboratorium', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('stok');
            $table->unsignedSmallInteger('tm_laboratorium_id');
            $table->unsignedInteger('tm_barang_id');
            $table->boolean('is_aktif')->default(1);
            $table->timestamps();

            $table->foreign('tm_laboratorium_id')->references('id')->on('tm_laboratorium')->onDelete('CASCADE');
            $table->foreign('tm_barang_id')->references('id')->on('tm_barang')->onDelete('CASCADE');
        });

        Schema::create('tr_member_laboratorium', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('tm_laboratorium_id');
            $table->unsignedInteger('tm_staff_id');
            $table->boolean('is_kalab')->default(0);
            $table->boolean('is_aktif')->default(1);
            $table->timestamps();

            $table->foreign('tm_laboratorium_id')->references('id')->on('tm_laboratorium')->onDelete('CASCADE');
            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onDelete('CASCADE');
        });

        Schema::create('tr_kartu_stok', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('tr_barang_laboratorium_id');
            $table->boolean('is_stok_in');
            $table->unsignedInteger('qty')->default(0);
            $table->unsignedInteger('stok');
            $table->unsignedSmallInteger('tr_member_laboratorium_id')->nullable();
            $table->unsignedBigInteger('tr_usulan_kebutuhan_detail_id')->nullable();
            $table->timestamps();

            $table->foreign('tr_member_laboratorium_id')->references('id')->on('tr_member_laboratorium')->onDelete('SET NULL');
            $table->foreign('tr_barang_laboratorium_id')->references('id')->on('tr_barang_laboratorium')->onDelete('CASCADE');
            $table->foreign('tr_usulan_kebutuhan_detail_id')->references('id')->on('tr_usulan_kebutuhan_detail')->onDelete('SET NULL');
        });

        Schema::table('tr_usulan_kebutuhan', function (Blueprint $table) {
            $table->unsignedSmallInteger('tm_laboratorium_id')->nullable();

            $table->foreign('tm_laboratorium_id')->references('id')->on('tm_laboratorium')->onDelete('SET NULL');
        });

        Schema::create('tr_kesiapan_praktek', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('tr_matakuliah_dosen_id');
            $table->unsignedInteger('tm_staff_id');
            $table->unsignedTinyInteger('rekomendasi')->comment("1=>Siapkan dan Lanjutkan, 2=>Dimodifikasi, 3=>Diganti Acara Praktek yang Lain, 4=>Ditunda");
            $table->timestamps();

            $table->foreign('tr_matakuliah_dosen_id')->references('id')->on('tr_matakuliah_dosen')->onDelete('CASCADE');
            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onDelete('CASCADE');
        });

        Schema::create('td_kesiapan_praktek_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('tr_barang_laboratorium_id');
            $table->unsignedInteger('tr_kesiapan_praktek_id');
            $table->unsignedInteger('jumlah')->default(0);
            $table->string('keterangan', 255);
            $table->timestamps();

            $table->foreign('tr_barang_laboratorium_id')->references('id')->on('tr_barang_laboratorium')->onDelete('CASCADE');
            $table->foreign('tr_kesiapan_praktek_id')->references('id')->on('tr_kesiapan_praktek')->onDelete('CASCADE');
        });

        Schema::create('tr_penggantian_praktek', function (Blueprint $table) {
            $table->Increments('id');
            $table->dateTime('jadwal_asli');
            $table->dateTime('jadwal_ganti');
            $table->string('acara_praktek', 255);
            $table->unsignedSmallInteger('tr_kaprodi_id');
            $table->unsignedSmallInteger('tr_member_laboratorium_id');
            $table->timestamps();

            $table->foreign('tr_kaprodi_id')->references('id')->on('tr_kaprodi')->onDelete('CASCADE');
            $table->foreign('tr_member_laboratorium_id')->references('id')->on('tr_member_laboratorium')->onDelete('CASCADE');
        });


    }

    public function down()
    {
        Schema::dropIfExists('tr_penggantian_praktek');
        Schema::dropIfExists('td_kesiapan_praktek_detail');
        Schema::dropIfExists('tr_kesiapan_praktek');
        Schema::table('tr_usulan_kebutuhan', function (Blueprint $table) {
            $table->dropColumn('tm_laboratorium_id');
        });
        Schema::dropIfExists('tr_kartu_stok');
        Schema::dropIfExists('tr_member_laboratorium');
        Schema::dropIfExists('tr_barang_laboratorium');
        Schema::dropIfExists('tm_laboratorium');
        Schema::dropIfExists('tr_kaprodi');
        Schema::dropIfExists('tr_kajur');
    }
}
