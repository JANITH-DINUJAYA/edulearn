<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ADD THIS
use Illuminate\Support\Facades\Auth;
class Assignment extends Model
{
    protected $fillable = ['course_id', 'instructor_id', 'title', 'description', 'due_date','attachment_path'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Optional: If you want to show submission counts later
     public function materials()
    {
        return $this->hasMany(AssignmentMaterial::class);
    }
    public function userSubmission()
{
    return $this->hasOne(Submission::class)->where('user_id', Auth::id());
}
public function submissions()
{
    return $this->hasMany(Submission::class);
}
}
