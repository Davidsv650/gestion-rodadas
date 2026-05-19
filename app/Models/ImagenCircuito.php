<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenCircuito extends Model
{
    protected $fillable = [
        'circuito_id',
        'imagen'
    ];

    public function circuito()
    {
        return $this->belongsTo(Circuito::class);
    }
}