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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->unique()->after('name');
            $table->string('angkatan')->nullable()->after('nim');
            $table->string('prodi')->nullable()->after('angkatan');
            $table->boolean('is_suspended')->default(false)->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'angkatan', 'prodi', 'is_suspended']);
        });
    }
};