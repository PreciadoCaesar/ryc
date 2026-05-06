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
        'status',
        'is_whatsapp',
        'advisor_id',
    ];

    protected $casts = [
        'is_whatsapp' => 'boolean',
    ];

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(Advisor::class);
    }
}
