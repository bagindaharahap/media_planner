<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', ['backlog', 'progress', 'review', 'revisi', 'hold_on', 'approved', 'published'])->default('backlog');
            $table->string('content_type')->default('TikTok');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('priority')->default('normal');
            $table->json('assigned')->nullable(); // Disimpan sebagai JSON karena array object
            $table->json('references')->nullable(); // Disimpan sebagai JSON karena array string
            $table->string('media_link')->nullable();
            $table->text('revision_note')->nullable(); // Untuk notes revisi yang baru kita buat
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plannings');
    }
};
