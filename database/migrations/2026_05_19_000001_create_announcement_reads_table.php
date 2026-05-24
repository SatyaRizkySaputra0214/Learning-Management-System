<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcement_reads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_announcement');
            $table->unsignedBigInteger('id_user');
            $table->timestamp('read_at')->useCurrent();
            $table->timestamps();

            $table->unique(['id_announcement', 'id_user']);

            $table->foreign('id_announcement')
                ->references('id')
                ->on('announcements')
                ->onDelete('cascade');

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcement_reads');
    }
};
