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
       Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
            $table->foreignId('course_id')
                  ->constrained('courses')
                  ->onDelete('cascade'); // foreign key to courses
            $table->foreignId('student_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // foreign key to users
            $table->timestamp('enrolled_at')->useCurrent(); // default CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};
