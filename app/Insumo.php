<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    public function edificio(){
        return $this->belongsTo(\App\Edificio::class, 'edificio_id');
    }

    public function insumosComprados(){
        return $this->hasMany(\App\InsumoComprado::class, 'insumo_id');
    }
}
