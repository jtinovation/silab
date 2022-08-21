<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableFrm001 extends Migration
{

    public function up()
    {
        Schema::create('tr_bon_alat', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('kode',32);
            $table->boolean('is_pegawai');
            $table->unsignedInteger('tm_staff_id')->nullable();
            $table->string('nama', 255);
            $table->string('nim', 255);
            $table->string('golongan_kelompok', 255);
            $table->dateTime('tanggal_pinjam');
            $table->unsignedSmallInteger('tr_member_laboratorium_id_pinjam')->nullable();
            $table->dateTime('tanggal_kembali');
            $table->string('pengembali', 255);
            $table->unsignedSmallInteger('tr_member_laboratorium_id_kembali')->nullable();
            $table->timestamps();

            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onDelete('SET NULL');
            $table->foreign('tr_member_laboratorium_id_pinjam')->references('id')->on('tr_member_laboratorium')->onDelete('SET NULL');
            $table->foreign('tr_member_laboratorium_id_kembali')->references('id')->on('tr_member_laboratorium')->onDelete('SET NULL');
        });

        Schema::create('td_bon_alat_detail', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('kode',32);
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('tr_bon_alat_id');
            $table->unsignedInteger('tr_barang_laboratorium_id');
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();
            $table->timestamps();

            $table->foreign('tr_bon_alat_id')->references('id')->on('tr_bon_alat')->onDelete('CASCADE');
            $table->foreign('tr_barang_laboratorium_id')->references('id')->on('tr_barang_laboratorium')->onDelete('CASCADE');
            $table->foreign('tr_kartu_stok_id')->references('id')->on('tr_kartu_stok')->onDelete('SET NULL');
        });

        Schema::create('tr_ijin_penggunaan_lbs', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('kode',32);
            $table->boolean('is_pegawai');
            $table->unsignedInteger('tm_staff_id')->nullable();
            $table->string('nama', 255);
            $table->string('nim', 255);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedInteger('tm_staff_id_pembimbing')->nullable();
            $table->unsignedSmallInteger('tm_program_studi_id')->nullable();
            $table->unsignedSmallInteger('tr_member_laboratorium_id')->nullable();
            $table->timestamps();

            $table->foreign('tm_staff_id')->references('id')->on('tm_staff')->onDelete('SET NULL');
            $table->foreign('tm_staff_id_pembimbing')->references('id')->on('tm_staff')->onDelete('SET NULL');
            $table->foreign('tm_program_studi_id')->references('id')->on('tm_program_studi')->onDelete('SET NULL');
            $table->foreign('tr_member_laboratorium_id')->references('id')->on('tr_member_laboratorium')->onDelete('SET NULL');
        });

        Schema::create('td_ijin_penggunaan_lbs_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode',32);
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('tr_ijin_penggunaan_lbs_id');
            $table->unsignedInteger('tr_barang_laboratorium_id');
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();
            $table->timestamps();

            $table->foreign('tr_ijin_penggunaan_lbs_id')->references('id')->on('tr_ijin_penggunaan_lbs')->onDelete('CASCADE');
            $table->foreign('tr_barang_laboratorium_id')->references('id')->on('tr_barang_laboratorium')->onDelete('CASCADE');
            $table->foreign('tr_kartu_stok_id')->references('id')->on('tr_kartu_stok')->onDelete('SET NULL');
        });

        Schema::create('tr_serma_hasil_sisa_praktek', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('kode',32);
            $table->unsignedInteger('tr_matakuliah_dosen_id');
            $table->unsignedSmallInteger('tr_member_laboratorium_id');
            $table->timestamps();

            $table->foreign('tr_matakuliah_dosen_id')->references('id')->on('tr_matakuliah_dosen')->onDelete('CASCADE');
            $table->foreign('tr_member_laboratorium_id')->references('id')->on('tr_member_laboratorium')->onDelete('CASCADE');
        });

        Schema::create('td_hasil_praktek', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode',32);
            $table->string('hasil_praktek',255);
            $table->string('keterangan',255);
            $table->unsignedInteger('tr_serma_hasil_sisa_praktek_id')->nullable();
            $table->timestamps();

            $table->foreign('tr_serma_hasil_sisa_praktek_id')->references('id')->on('tr_serma_hasil_sisa_praktek')->onDelete('CASCADE');
        });

        Schema::create('td_sisa_praktek', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode',32);
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('tr_barang_laboratorium_id');
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();
            $table->unsignedInteger('tr_serma_hasil_sisa_praktek_id')->nullable();
            $table->timestamps();

            $table->foreign('tr_barang_laboratorium_id')->references('id')->on('tr_barang_laboratorium')->onDelete('CASCADE');
            $table->foreign('tr_kartu_stok_id')->references('id')->on('tr_kartu_stok')->onDelete('SET NULL');
            $table->foreign('tr_serma_hasil_sisa_praktek_id')->references('id')->on('tr_serma_hasil_sisa_praktek')->onDelete('CASCADE');
        });

        Schema::create('tr_hilang_rusak', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('kode',32);
            $table->string('nama', 255);
            $table->string('nim', 255);
            $table->string('golongan_kelompok', 255);
            $table->dateTime('tanggal_sanggup');
            $table->unsignedSmallInteger('tr_member_laboratorium_id');
            $table->timestamps();

            $table->foreign('tr_member_laboratorium_id')->references('id')->on('tr_member_laboratorium')->onDelete('CASCADE');
        });

        Schema::create('td_hilang_rusak_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode',32);
            $table->unsignedInteger('tr_barang_laboratorium_id');
            $table->unsignedInteger('tr_hilang_rusak_id');
            $table->timestamps();

            $table->foreign('tr_barang_laboratorium_id')->references('id')->on('tr_barang_laboratorium')->onDelete('CASCADE');
            $table->foreign('tr_hilang_rusak_id')->references('id')->on('tr_hilang_rusak')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('td_hilang_rusak_detail');
        Schema::dropIfExists('tr_hilang_rusak');
        Schema::dropIfExists('td_sisa_praktek');
        Schema::dropIfExists('td_hasil_praktek');
        Schema::dropIfExists('tr_serma_hasil_sisa_praktek');
        Schema::dropIfExists('td_ijin_penggunaan_lbs_detail');
        Schema::dropIfExists('tr_ijin_penggunaan_lbs');
        Schema::dropIfExists('td_bon_alat_detail');
        Schema::dropIfExists('tr_bon_alat');
    }
}
