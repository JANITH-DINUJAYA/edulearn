<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Important: Add these to allow mass assignment
    protected $fillable = [
        'quiz_id',
        'question_text',
        'type',
        'options',
        'correct_answer'
    ];

    // Tell Laravel to automatically handle the options as an array/JSON
    protected $casts = [
        'options' => 'array',
    ];
}
