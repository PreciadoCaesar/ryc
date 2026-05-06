<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'slug', 'type', 'phrase', 'description',
        'image_promotion', 'link_brochure', 'link_niubiz', 'specialization_name',
        'start_date', 'sessions', 'hours',
        'asesora_id',
        'inhouse_web', 'inhouse_mobile',
        'seo_title', 'seo_description', 'seo_keywords',
        'precio_flash_fecha', 'precio_flash', 'precio_regular',
        'precio_pronto_fecha', 'precio_pronto',
        'featured', 'status',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'hours' => 'integer',
        'sessions' => 'integer',
    ];

    protected $table = 'courses';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function page()
    {
        return $this->hasOne(CoursePage::class);
    }

    public function objetivos()
    {
        return $this->hasMany(CourseObjetivo::class)->orderBy('orden');
    }

    public function participantes()
    {
        return $this->hasMany(CourseParticipante::class)->orderBy('orden');
    }

    public function temario()
    {
        return $this->hasMany(CourseSesion::class)->orderBy('numero');
    }

    public function profesores()
    {
        return $this->belongsToMany(Professor::class, 'course_professor');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeActivos($query)
    {
        return $query->where('status', 'activo');
    }

    public function scopeEnVivo($query)
    {
        return $query->where('mode', 'en_vivo');
    }

    public function scopeGrabado($query)
    {
        return $query->where('mode', 'grabado');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
