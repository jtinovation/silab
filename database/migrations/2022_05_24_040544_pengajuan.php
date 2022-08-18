<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengajuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_matakuliah_semester_prodi', function($table) {
            $table->unsignedTinyInteger('jumlah_golongan');
        });

        Schema::create('tm_tahun_ajaran', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('tahun_ajaran', 10)->nullable();
            $table->timestamps();
        });

        Schema::create('tm_minggu', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('minggu_ke');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('tm_tahun_ajaran_id')->nullable();
            $table->timestamps();

            $table->foreign('tm_tahun_ajaran_id')
            ->references('id')->on('tm_tahun_ajaran')
            ->onDelete('SET NULL');
        });

        Schema::create('tm_satuan', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('satuan', 64);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });

        Schema::create('tm_jenis_barang', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('jenis_barang', 8)->nullable();
            $table->timestamps();
        });

        Schema::create('tm_barang', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nama_barang', 64);
            $table->string('spesifikasi', 255);
            $table->string('keterangan', 255);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedSmallInteger('tm_satuan_id')->nullable();
            $table->unsignedTinyInteger('tm_jenis_barang_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('tm_satuan_id')->references('id')->on('tm_satuan')->onDelete('SET NULL');
            $table->foreign('tm_jenis_barang_id')->references('id')->on('tm_jenis_barang')->onDelete('SET NULL');
        });

        Schema::create('td_satuan', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('qty')->nullable();
            $table->unsignedSmallInteger('tm_satuan_id')->nullable();
            $table->unsignedInteger('tm_barang_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('tm_satuan_id')->references('id')->on('tm_satuan')->onDelete('SET NULL');
            $table->foreign('tm_barang_id')->references('id')->on('tm_barang')->onDelete('SET NULL');
        });

        Schema::create('tr_usulan_kebutuhan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('acara_praktek', 64);
            $table->unsignedTinyInteger('keb_kel');
            $table->unsignedTinyInteger('jml_kel');
            $table->string('keterangan', 255);
            $table->unsignedTinyInteger('status')->comment('1 => pengajuan, 2 =>review tim bahan, 3 => cetak tim bahan, 4 => acc ');
            $table->unsignedInteger('td_satuan_id')->nullable();
            $table->unsignedTinyInteger('tm_minggu_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedInteger('tm_barang_id')->nullable();
            $table->unsignedInteger('tr_matakuliah_dosen_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('td_satuan_id')->references('id')->on('td_satuan')->onDelete('SET NULL');
            $table->foreign('tm_minggu_id')->references('id')->on('tm_minggu')->onDelete('SET NULL');
            $table->foreign('tm_barang_id')->references('id')->on('tm_barang')->onDelete('SET NULL');
            $table->foreign('tr_matakuliah_dosen_id')->references('id')->on('tr_matakuliah_dosen')->onDelete('SET NULL');
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */


    public function down()
    {
        Schema::dropIfExists('tr_usulan_kebutuhan');
        Schema::dropIfExists('td_satuan');
        Schema::dropIfExists('tm_barang');
        Schema::dropIfExists('tm_jenis_barang');
        Schema::dropIfExists('tm_satuan');
        Schema::dropIfExists('tm_minggu');
        Schema::dropIfExists('tm_tahun_ajaran');
        Schema::table('tr_matakuliah_semester_prodi', function (Blueprint $table) {
            $table->dropColumn('jumlah_golongan');
        });


    }
}
