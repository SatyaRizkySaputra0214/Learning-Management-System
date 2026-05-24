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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_meeting')->constrained('meetings')->onDelete('cascade');
            $table->foreignId('id_skill')->constrained('skills')->onDelete('cascade');
            $table->string('judul_tugas');
            $table->text('deskripsi');
            $table->timestamp('deadline')->nullable();
            $table->integer('poin_maksimal')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
