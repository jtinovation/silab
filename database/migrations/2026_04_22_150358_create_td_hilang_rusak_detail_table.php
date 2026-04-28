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
        Schema::create('td_hilang_rusak_detail', function (Blueprint $table) {
            // #1 - id: BIGINT(20), UNSIGNED, NOT NULL, AUTO_INCREMENT, PRIMARY KEY
            $table->id();

            // #2 - kode: VARCHAR(32), Allow Null, Default NULL
            $table->string('kode', 32)->nullable()->collation('utf8mb4_unicode_ci');

            // #3 - tr_barang_lab_id: INT(10), UNSIGNED, NOT NULL, No default (FK)
            $table->unsignedInteger('tr_barang_lab_id');

            // #4 - tr_hilang_rusak_id: INT(10), UNSIGNED, NOT NULL, No default (FK)
            $table->unsignedInteger('tr_hilang_rusak_id');

            // #5 - created_at: TIMESTAMP, Allow Null, Default NULL
            $table->timestamp('created_at')->nullable();

            // #6 - jumlah_hilang_rusak: INT(10), UNSIGNED, NOT NULL, No default
            $table->unsignedInteger('jumlah_hilang_rusak');

            // #7 - status: TINYINT(3), UNSIGNED, Allow Null, Default '0'
            $table->tinyInteger('status')->unsigned()->nullable()->default(0);

            // #8 - updated_at: TIMESTAMP, Allow Null, Default NULL
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_hilang_rusak_detail');
    }
};