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
       Schema::table('lesson_completions', function (Blueprint $table) {
        // Only add these if they don't already exist in your database
        if (!Schema::hasColumn('lesson_completions', 'user_id')) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        }
        if (!Schema::hasColumn('lesson_completions', 'lesson_id')) {
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
        }
        if (!Schema::hasColumn('lesson_completions', 'course_id')) {
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_completions', function (Blueprint $table) {
            //
        });
    }
};
