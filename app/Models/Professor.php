<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $fillable = ['name', 'photo', 'formacion', 'experiencia'];
    protected $casts = ['formacion' => 'array', 'experiencia' => 'array'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_professor');
    }
}
