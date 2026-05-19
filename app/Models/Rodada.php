<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rodada extends Model
{
    protected $casts = [

        'fecha' => 'date',

        // 🔥 FINALIZADA AUTOMÁTICA
        'finalizada' => 'boolean',

    ];

    protected $fillable = [

        'fecha',
        'organizador_id',
        'titulo',
        'circuito_id',
        'descripcion',
        'plazas',
        'precio',

    ];

    /**
     * INSCRITOS
     */

    public function inscritos()
    {
        return $this->hasMany(
            'App\Models\Inscripcion',
            'rodada_id'
        );
    }

    /**
     * CIRCUITO
     */

    public function circuito()
    {
        return $this->belongsTo(
            'App\Models\Circuito'
        );
    }

    /**
     * ORGANIZADOR
     */

    public function organizador()
    {
        return $this->belongsTo(
            'App\Models\Organizador'
        );
    }
}