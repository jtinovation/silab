<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            // Kolom email sebagai primary key dengan panjang 191
            $table->string('email', 191)->primary();
            
            // Kolom token dengan panjang 191
            $table->string('token', 191);
            
            // Kolom created_at yang boleh bernilai NULL (Allow Null)
            $table->timestamp('created_at')->nullable();

            /**
             * Relasi Foreign Key:
             * Menghubungkan email di tabel ini ke kolom email di tabel users.
             * cascadeOnDelete: Jika user dihapus, data reset password-nya ikut terhapus.
             */
            $table->foreign('email')
                  ->references('email')
                  ->on('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}