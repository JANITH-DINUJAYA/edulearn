<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_title' => 'required|string|max:255',
            'file' => 'required|mimes:mp4,mov,pdf|max:512000', // 500MB
        ]);

        if ($request->hasFile('file')) {
            // Save file to 'storage/app/public/lessons'
            $path = $request->file('file')->store('lessons', 'public');

            Lesson::create([
                'course_id' => $request->course_id,
                'title' => $request->lesson_title,
                'file_path' => $path,
                'file_type' => $request->file('file')->getClientOriginalExtension(),
            ]);
        }

        return back()->with('success', 'Lesson "' . $request->lesson_title . '" uploaded successfully! 🎉');
    }
}
