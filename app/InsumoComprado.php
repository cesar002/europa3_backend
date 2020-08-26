<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumoComprado extends Model
{
    protected $table = 'insumos_comprados';

    public function insumo(){
        return $this->belongsTo(\App\Insumo::class, 'insumo_id');
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function oficina(){
        return $this->belongsTo(\App\Oficina::class, 'oficina_id');
    }

    public function usados(){
        return $this->hasMany(\App\InsumoUsado::class, 'insumo_comprado_id');
    }
}
