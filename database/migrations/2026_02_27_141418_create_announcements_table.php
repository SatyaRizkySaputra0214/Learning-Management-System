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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_meeting')->constrained('meetings')->onDelete('cascade');
            $table->foreignId('id_guru')->constrained('users')->onDelete('cascade');
            $table->string('judul_pengumuman');
            $table->text('isi_pengumuman');
            $table->boolean('is_penting')->default(false);
            $table->timestamp('published_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
