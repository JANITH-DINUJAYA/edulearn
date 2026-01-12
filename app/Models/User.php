<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // ADD THIS IMPORT

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'streak_count',
    'last_activity_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ---------------- TEACHER RELATIONSHIPS ---------------- */

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /* ---------------- STUDENT RELATIONSHIPS ---------------- */

    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_enrollments', 'student_id', 'course_id');
    }

    /**
     * Lessons the student has finished (This was missing from your code)
     */
    public function completedLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_completions', 'student_id', 'lesson_id')
                    ->withTimestamps();
    }

    public function quizSubmissions(): HasMany
    {

         return $this->hasMany(QuizAttempt::class, 'user_id');
         return $this->hasMany(QuizSubmission::class, 'student_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'student_id');
        return $this->hasMany(Certificate::class, 'user_id');
    }

    public function messagesSent()
{
    return $this->hasMany(Message::class, 'sender_id');
}

/**
 * Messages received by this user
 */
public function messagesReceived()
{
    return $this->hasMany(Message::class, 'recipient_id');
}
public function submissions(): HasMany
{
    return $this->hasMany(Submission::class);
}
}
