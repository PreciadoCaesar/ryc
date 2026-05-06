<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advisor extends Model
{
    protected $fillable = ['name', 'whatsapp', 'photo', 'email', 'cargo'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
