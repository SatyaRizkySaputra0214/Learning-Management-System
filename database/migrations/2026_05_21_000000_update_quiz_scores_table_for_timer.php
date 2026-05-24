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
        Schema::table('quiz_scores', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_scores', 'started_at')) {
                $table->timestamp('started_at')->nullable()->after('id_student');
            }
            if (!Schema::hasColumn('quiz_scores', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('started_at');
            }
            $table->integer('skor')->nullable()->change();
            $table->integer('total_poin')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_scores', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_scores', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            // We keep started_at if it was already there
            $table->integer('skor')->nullable(false)->change();
            $table->integer('total_poin')->nullable(false)->change();
        });
    }
};
