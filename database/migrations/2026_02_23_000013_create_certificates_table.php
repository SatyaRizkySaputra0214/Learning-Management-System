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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_student')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_class')->constrained('classes')->onDelete('cascade');
            $table->string('nomor_sertifikat')->unique();
            $table->string('file_pdf_url')->nullable();
            $table->date('tgl_terbit');
            $table->decimal('nilai_reading', 5, 2)->nullable();
            $table->decimal('nilai_writing', 5, 2)->nullable();
            $table->decimal('nilai_listening', 5, 2)->nullable();
            $table->decimal('nilai_speaking', 5, 2)->nullable();
            $table->decimal('nilai_grammar', 5, 2)->nullable();
            $table->decimal('rata_rata_total', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
