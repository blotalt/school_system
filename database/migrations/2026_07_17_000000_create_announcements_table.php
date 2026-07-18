<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            // Who the announcement is for: everyone / students / teachers,
            // or a specific class (audience = 'class' + class_id set).
            $table->enum('audience', ['everyone', 'students', 'teachers', 'class'])->default('everyone');
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->enum('priority', ['normal', 'medium', 'high'])->default('normal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
