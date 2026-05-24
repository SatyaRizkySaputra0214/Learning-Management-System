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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_assignment')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('id_student')->constrained('users')->onDelete('cascade');
            $table->string('file_url');
            $table->text('catatan_siswa')->nullable();
            $table->decimal('nilai_guru', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();
            
            $table->unique(['id_assignment', 'id_student']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
