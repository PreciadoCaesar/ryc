<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advisor extends Model
{
    protected $fillable = ['name', 'whatsapp', 'photo', 'photo_web', 'email', 'cargo', 'tipo'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'asesora_id');
    }

    public function inhouseCourses()
    {
        return $this->hasMany(Course::class, 'asesor_inhouse_id');
    }

    public function scopeAsesoras($query)
    {
        return $query->where('tipo', 'asesora');
    }

    public function scopeInhouse($query)
    {
        return $query->where('tipo', 'inhouse');
    }
}
