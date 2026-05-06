<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSesion extends Model
{
    protected $table = 'course_sesiones';
    protected $fillable = ['course_id', 'numero', 'titulo', 'temas'];
    protected $casts = ['numero' => 'integer', 'temas' => 'array'];
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}