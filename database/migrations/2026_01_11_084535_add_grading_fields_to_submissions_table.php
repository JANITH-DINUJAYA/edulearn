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
    Schema::table('submissions', function (Blueprint $table) {
        $table->string('status')->default('pending')->after('file_path');
        $table->string('grade')->nullable()->after('status');
        $table->text('feedback')->nullable()->after('grade');
    });
}

public function down(): void
{
    Schema::table('submissions', function (Blueprint $table) {
        $table->dropColumn(['status', 'grade', 'feedback']);
    });
}
};
