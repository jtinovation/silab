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
        Schema::create('td_hasil_praktek', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, NOT NULL, AUTO_INCREMENT, PRIMARY KEY
            $table->id();

            // #2 - kode: VARCHAR(32), Allow Null, Default NULL
            $table->string('kode', 32)->nullable()->collation('utf8mb4_unicode_ci');

            // #3 - jumlah: INT(10), UNSIGNED, NOT NULL, No default
            $table->unsignedInteger('jumlah');

            // #4 - tr_barang_lab_id: INT(10), UNSIGNED, NOT NULL, No default
            $table->unsignedInteger('tr_barang_lab_id');

            // #5 - tr_serma_hasil_id: INT(10), UNSIGNED, Allow Null, Default NULL (FK)
            $table->unsignedInteger('tr_serma_hasil_id')->nullable();

            // #6 & #7 - created_at & updated_at: TIMESTAMP, Allow Null
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // #8 - tr_kartu_stok_id: INT(10), UNSIGNED, Allow Null, Default NULL
            $table->unsignedInteger('tr_kartu_stok_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_hasil_praktek');
    }
};