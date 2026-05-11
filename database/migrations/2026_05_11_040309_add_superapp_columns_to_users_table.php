<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('external_id')->nullable()->unique()->after('id');
            $table->string('nim_nidn')->nullable()->after('email');
            $table->string('photo_url')->nullable()->after('nim_nidn');
            $table->string('user_type')->nullable()->after('photo_url');
            $table->json('roles')->nullable()->after('user_type');
            $table->json('permissions')->nullable()->after('roles');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'external_id',
                'nim_nidn',
                'photo_url',
                'user_type',
                'roles',
                'permissions'
            ]);
        });
    }
};