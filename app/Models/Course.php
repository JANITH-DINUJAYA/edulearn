<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model

{   protected $table = 'courses';
    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'status',
        'instructor_id',
        'user_id',
        'rating'
    ];

    protected $casts = [
        'rating' => 'decimal:2'
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    // Helper method to get student count
    public function getStudentCountAttribute(): int
    {
        return $this->enrollments()->count();
    }

    // Helper method to get course initials for avatar
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->title);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->title, 0, 2));
    }
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
    public function courses(): HasMany
    {
        // Ensure 'user_id' matches the column name in your courses table
        return $this->hasMany(Course::class, 'user_id');
    }
// app/Models/Course.php

public function assignments(): HasMany
{
    // This looks for 'course_id' inside the assignments table
    return $this->hasMany(Assignment::class);
}
public function ratings()
{
    return $this->hasMany(CourseRating::class);
}
}
