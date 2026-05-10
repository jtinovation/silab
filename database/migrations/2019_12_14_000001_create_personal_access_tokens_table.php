<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            // id: BIGINT(20), Unsigned, Auto Increment (Kunci Kuning)
            $table->id();

            /** * tokenable_type & tokenable_id (Kunci Hijau)
             * Menggunakan morphs untuk menangani relasi ke berbagai model.
             * Panjang string diset 191 sesuai gambar.
             */
            $table->string('tokenable_type', 191);
            $table->unsignedBigInteger('tokenable_id');
            $table->index(['tokenable_type', 'tokenable_id']); 

            // name: VARCHAR(191)
            $table->string('name', 191); 

            // token: VARCHAR(64), Unique (Kunci Merah)
            $table->string('token', 64)->unique();

            // abilities: TEXT, Allow Null
            $table->text('abilities')->nullable();

            // last_used_at: TIMESTAMP, Allow Null
            $table->timestamp('last_used_at')->nullable();

            /** * timestamps() menghasilkan:
             * created_at: TIMESTAMP, Allow Null
             * updated_at: TIMESTAMP, Allow Null
             */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
}