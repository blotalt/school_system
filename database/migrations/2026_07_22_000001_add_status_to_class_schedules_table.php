<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('shift');
            $table->text('rejection_note')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_note']);
        });
    }
};