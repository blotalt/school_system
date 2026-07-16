<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->foreignId('teacher_id')
                  ->nullable()
                  ->after('grade_level')
                  ->constrained('teachers')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Teacher::class);
            $table->dropColumn('teacher_id');
        });
    }
};
