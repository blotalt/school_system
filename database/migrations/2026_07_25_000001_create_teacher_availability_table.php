<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->enum('day_of_week', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']);
            $table->unsignedTinyInteger('period');
            $table->enum('shift', ['morning', 'afternoon']);
            $table->enum('status', ['available', 'preferred', 'unavailable'])->default('unavailable');
            $table->timestamps();
            $table->unique(['teacher_id', 'day_of_week', 'period', 'shift']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_availability');
    }
};