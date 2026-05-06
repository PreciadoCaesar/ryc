<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePage extends Model
{
    protected $fillable = ['course_id', 'content'];

    protected $casts = [
        'content' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
