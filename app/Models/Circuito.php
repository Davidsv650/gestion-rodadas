<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circuito extends Model
{
    //

        protected $fillable = [
        'nombre',
        'ubicacion',
        'descripcion',
        'frase',
        'imagen',
        'longitud',
        'numero_de_curvas',
    ];

          public function rodadas()
    {
        return $this->hasMany('App\Models\Rodada','circuito_id');
    }
    public function imagenes()
{
    return $this->hasMany(ImagenCircuito::class);
}
}
