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
       Schema::create('quiz_submissions', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
            $table->foreignId('quiz_id')
                  ->constrained('quizzes')
                  ->onDelete('cascade'); // link to quizzes
            $table->foreignId('student_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // link to users
            $table->enum('status', ['pending', 'graded'])->default('pending');
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps(); // optional: keeps created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
