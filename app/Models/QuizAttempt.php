<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'correct_answers',
        'total_questions'
    ];

    // Optional: Add relationship to get the Quiz details easily
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
