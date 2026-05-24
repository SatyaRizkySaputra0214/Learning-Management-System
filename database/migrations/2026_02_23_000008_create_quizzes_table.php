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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_meeting')->constrained('meetings')->onDelete('cascade');
            $table->foreignId('id_skill')->constrained('skills')->onDelete('cascade');
            $table->string('judul_kuis');
            $table->text('deskripsi')->nullable();
            $table->integer('durasi')->nullable(); // in minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
