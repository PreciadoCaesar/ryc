<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $fillable = ['name', 'primer_nombre', 'photo', 'secciones', 'bio'];
    protected $casts = ['secciones' => 'array'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_professor');
    }
}
