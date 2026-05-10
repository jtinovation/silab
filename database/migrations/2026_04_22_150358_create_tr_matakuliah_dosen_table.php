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
        Schema::create('tr_matakuliah_dosen', function (Blueprint $table) {
            // #1 - id: INT(10), UNSIGNED, AUTO_INCREMENT
            $table->increments('id');

            // #2 - tr_matakuliah_semester_prodi_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tr_matakuliah_semester_prodi_id')->nullable();

            // #3 - tm_staff_id: INT(10), UNSIGNED, Allow Null (FK)
            $table->unsignedInteger('tm_staff_id')->nullable();

            // #4 - user_id: BIGINT(20), UNSIGNED, Allow Null (FK)
            $table->unsignedBigInteger('user_id')->nullable();

            // #5 & #6 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamps();

            // --- Definisi Foreign Key sesuai simbol kunci di gambar ---

            $table->foreign('tr_matakuliah_semester_prodi_id', 'fk_tr_mk_dosen_prodi')
                  ->references('id')->on('tr_matakuliah_semester_prodi')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('tm_staff_id', 'fk_tr_mk_dosen_staff')
                  ->references('id')->on('tm_staff')
                  ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('user_id', 'fk_tr_mk_dosen_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_matakuliah_dosen');
    }
};