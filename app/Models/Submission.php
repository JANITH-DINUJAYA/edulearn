<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    // Add all the columns you are sending in the Submission::create() method
    protected $fillable = [
        'user_id',
        'assignment_id',
        'file_path',
        'status',
        'grade',
        'feedback', // Add this if you plan to track 'pending' or 'graded'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
