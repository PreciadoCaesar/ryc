<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseParticipante extends Model
{
    protected $table = 'course_participantes';
    protected $fillable = ['course_id', 'icono', 'descripcion', 'orden'];
    protected $casts = ['orden' => 'integer'];
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}