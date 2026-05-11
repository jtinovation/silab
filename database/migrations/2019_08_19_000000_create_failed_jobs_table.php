<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            // id: BIGINT(20), Unsigned, Auto Increment, Primary Key
            $table->id();

            // uuid: VARCHAR(191), Unique (Kunci merah di gambar)
            $table->string('uuid', 191)->unique();

            // connection & queue: TEXT
            $table->text('connection');
            $table->text('queue');

            // payload & exception: LONGTEXT
            $table->longText('payload');
            $table->longText('exception');

            // failed_at: TIMESTAMP, Default CURRENT_TIMESTAMP
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}