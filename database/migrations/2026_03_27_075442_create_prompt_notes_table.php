<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('prompt_notes', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('category');
        $table->longText('description')->nullable();
        
        // Tambahkan 2 baris ini:
        $table->string('log_action')->nullable();
        $table->string('log_user')->nullable();
        
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('prompt_notes');
    }
};