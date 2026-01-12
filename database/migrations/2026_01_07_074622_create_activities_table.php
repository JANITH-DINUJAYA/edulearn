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
          Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
            $table->foreignId('user_id')        // Who receives the notification
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('instructor_id')  // Related instructor
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->enum('type', ['enrollment', 'comment', 'quiz_completion', 'message']);
            $table->string('title', 255);
            $table->text('description');
            $table->foreignId('course_id')      // Optional, can be null
                  ->nullable()
                  ->constrained('courses')
                  ->nullOnDelete();
            $table->timestamps();               // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
