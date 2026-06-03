<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rodada extends Model
{
    protected $casts = [

        'fecha' => 'date',

        // finalización automatica de la rodada
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
     * inscritos
     */

    public function inscritos()
    {
        return $this->hasMany(
            'App\Models\Inscripcion',
            'rodada_id'
        );
    }

    /**
     * circuitos
     */

    public function circuito()
    {
        return $this->belongsTo(
            'App\Models\Circuito'
        );
    }

    /**
     * organizadores
     */

    public function organizador()
    {
        return $this->belongsTo(
            'App\Models\Organizador'
        );
    }
}