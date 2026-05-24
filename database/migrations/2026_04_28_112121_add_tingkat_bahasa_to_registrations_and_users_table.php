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
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('tingkat_bahasa')->nullable()->after('kursus_pilihan');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('tingkat_bahasa')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('tingkat_bahasa');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tingkat_bahasa');
        });
    }
};
