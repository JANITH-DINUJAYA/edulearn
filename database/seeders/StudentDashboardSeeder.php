<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $student = \App\Models\User::where('role', 'student')->first();
    $course = \App\Models\Course::first();

    if ($student && $course) {
        // 1. Enroll the student
        $student->enrolledCourses()->syncWithoutDetaching([$course->id]);

        // 2. Mark some lessons as complete
        $lessons = $course->lessons()->take(2)->get();
        foreach ($lessons as $lesson) {
            $student->completedLessons()->syncWithoutDetaching([$lesson->id]);
        }
    }
}
}
