<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->unsignedTinyInteger('period');
            $table->enum('shift', ['morning', 'afternoon']);
            $table->timestamps();

            // One lesson per class per slot.
            $table->unique(['class_id', 'day_of_week', 'period', 'shift']);
            // A teacher cannot teach two classes in the same slot.
            $table->unique(['teacher_id', 'day_of_week', 'period', 'shift']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
