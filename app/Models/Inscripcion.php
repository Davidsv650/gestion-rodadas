<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    //
      protected $table = 'inscripciones'; // nombre correcto en la base de datos
        protected $casts = [
        'fecha' => 'date',
    ];

        protected $fillable = [
        'usuario_id',
        'rodada_id',
        'estado',
        'fecha',
    ];


    

      public function rodada()
    {
        return $this->belongsTo('App\Models\Rodada');
    }

         public function usuario()
    {
         return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }
}
