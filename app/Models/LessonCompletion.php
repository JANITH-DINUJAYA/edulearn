<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonCompletion extends Model
{
    // This allows Laravel to insert data into these columns
    protected $fillable = ['user_id', 'lesson_id', 'course_id'];
}
