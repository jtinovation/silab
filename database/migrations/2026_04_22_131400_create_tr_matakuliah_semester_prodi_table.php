<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tr_matakuliah_semester_prodi', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - tm_program_studi_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_program_studi_id')->nullable();

            // #3 - tm_semester_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_semester_id')->nullable();

            // #4 - tm_matakuliah_id: SMALLINT(5), UNSIGNED, Allow Null (FK)
            $table->unsignedSmallInteger('tm_matakuliah_id')->nullable();

            // #5 - user_id: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('user_id')->nullable();

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // #8 - jumlah_golongan: TINYINT(3), UNSIGNED, NOT NULL
            $table->unsignedTinyInteger('jumlah_golongan');

            // --- Definisi Foreign Key sesuai simbol kunci di gambar ---

            $table->foreign('tm_program_studi_id', 'fk_tr_mk_prodi_studi')
                  ->references('id')->on('tm_program_studi')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_semester_id', 'fk_tr_mk_prodi_semester')
                  ->references('id')->on('tm_semester')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_matakuliah_id', 'fk_tr_mk_prodi_mk')
                  ->references('id')->on('tm_matakuliah')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('user_id', 'fk_tr_mk_prodi_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_matakuliah_semester_prodi');
    }
};