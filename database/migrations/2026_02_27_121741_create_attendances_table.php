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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_meeting')->constrained('meetings')->onDelete('cascade');
            $table->foreignId('id_student')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamp('checked_at')->useCurrent();
            $table->timestamps();

            $table->unique(['id_meeting', 'id_student']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
