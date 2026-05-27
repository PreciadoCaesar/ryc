<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseObjetivo extends Model
{
    protected $table = 'course_objetivos';
    protected $fillable = ['course_id', 'titulo', 'descripcion', 'orden'];
    protected $casts = ['orden' => 'integer'];
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}