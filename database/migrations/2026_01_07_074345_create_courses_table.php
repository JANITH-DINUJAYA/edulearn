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
          Schema::create('courses', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
            $table->foreignId('instructor_id') // BIGINT UNSIGNED
                  ->constrained('users')      // references users(id)
                  ->onDelete('cascade');
            $table->string('title');         // VARCHAR(255)
            $table->text('description');     // TEXT
            $table->enum('status', ['draft', 'active', 'archived'])
                  ->default('active');       // ENUM
            $table->decimal('rating', 3, 2)->default(0); // DECIMAL(3,2)
            $table->timestamps();            // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
