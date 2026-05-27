<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'nombre',
        'celular',
        'correo',
        'consulta',
        'curso',
        'origen',
        'institucion',
        'cantidad_alumnos',
        'nivel_curso',
        'status',
        'is_whatsapp',
        'advisor_id',
        'contacted_at',
    ];

    protected $casts = [
        'is_whatsapp' => 'boolean',
        'contacted_at' => 'datetime',
    ];

    public function getTiempoRespuestaAttribute(): ?string
    {
        if (!$this->contacted_at || !$this->created_at) {
            return null;
        }
        $diff = $this->created_at->diffInMinutes($this->contacted_at);
        $horas = floor($diff / 60);
        $minutos = $diff % 60;
        if ($horas > 0) {
            return "{$horas}h {$minutos}m";
        }
        return "{$minutos}m";
    }

    public function getRespuestaRapidaAttribute(): bool
    {
        if (!$this->contacted_at || !$this->created_at) {
            return false;
        }
        return $this->created_at->diffInMinutes($this->contacted_at) <= 6;
    }

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(Advisor::class);
    }
}
