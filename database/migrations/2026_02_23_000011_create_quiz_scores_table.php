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
        Schema::create('quiz_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_quiz')->constrained('quizzes')->onDelete('cascade');
            $table->foreignId('id_student')->constrained('users')->onDelete('cascade');
            $table->integer('skor');
            $table->integer('total_poin');
            $table->timestamps();
            
            $table->unique(['id_quiz', 'id_student']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_scores');
    }
};
