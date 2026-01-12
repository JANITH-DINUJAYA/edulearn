<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ADD THIS

class AssignmentMaterial extends Model
{
    protected $fillable = [
        'assignment_id',
        'file_path',
        'link'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
