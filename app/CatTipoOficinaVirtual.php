<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatTipoOficinaVirtual extends Model
{
    protected $table = 'cat_tipo_oficina_virtual';

    public function oficinas(){
        return $this->hasMany(\App\Oficina::class, 'tipo_oficina_virtual_id');
    }
}
