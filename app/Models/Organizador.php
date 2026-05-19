<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizador extends Model
{
    //

       protected $fillable = [
        'nombre',
        'descripcion',
        'web',
        'telefono',
        'email',
    ];
    
       public function rodadas()
    {
        return $this->hasMany('App\Models\Rodada','organizador_id');
    }
}
