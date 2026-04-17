<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class TabelJurusanProdiMKSemester extends Migration
{
    public function up()
    {
        Schema::create('tm_jurusan', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('kode', 8)->nullable();
            $table->string('jurusan', 64);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });

        Schema::create('tm_program_studi', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('kode', 12)->nullable();
            $table->string('program_studi', 64);
            $table->unsignedTinyInteger('tm_jurusan_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('tm_jurusan_id')
            ->references('id')->on('tm_jurusan')
            ->onDelete('CASCADE');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });

        Schema::create('tm_matakuliah', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('kode', 12)->nullable();
            $table->string('matakuliah', 64);
            $table->boolean('is_aktif');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });

        Schema::create('tm_semester', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('tahun_ajaran', 16);
            $table->unsignedTinyInteger('semester');
            $table->boolean('is_genap');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });

        Schema::create('tr_matakuliah_semester_prodi', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedSmallInteger('tm_program_studi_id')->nullable();
            $table->unsignedSmallInteger('tm_semester_id')->nullable();
            $table->unsignedSmallInteger('tm_matakuliah_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('tm_matakuliah_id')
            ->references('id')->on('tm_matakuliah')
            ->onDelete('SET NULL');

            $table->foreign('tm_program_studi_id')
            ->references('id')->on('tm_program_studi')
            ->onDelete('SET NULL');

            $table->foreign('tm_semester_id')
            ->references('id')->on('tm_semester')
            ->onDelete('SET NULL');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });



        Schema::create('tr_matakuliah_dosen', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('tr_matakuliah_semester_prodi_id')->nullable();
            $table->unsignedInteger('tm_staff_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('tr_matakuliah_semester_prodi_id')
            ->references('id')->on('tr_matakuliah_semester_prodi')
            ->onDelete('SET NULL');

            $table->foreign('tm_staff_id')
            ->references('id')->on('tm_staff')
            ->onDelete('SET NULL');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('SET NULL');
        });

    }

    public function down()
    {
        Schema::dropIfExists('tm_minggu');
        Schema::dropIfExists('tr_matakuliah_dosen');
        Schema::dropIfExists('tr_matakuliah_semester_prodi');
        Schema::dropIfExists('tm_semester');
        Schema::dropIfExists('tm_matakuliah');
        Schema::dropIfExists('tm_program_studi');
        Schema::dropIfExists('tm_jurusan');
    }
}
