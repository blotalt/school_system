<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('subject_specialty');
            $table->string('gender')->nullable()->after('date_of_birth');
            $table->string('phone')->nullable()->after('gender');
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'gender', 'phone']);
        });
    }
};
