<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatSizeOficina extends Model
{
	protected $table = 'cat_size_oficina';

	protected $fillable = [
		'size', 'precio'
	];

	protected $hidden = [
		'created_at', 'updated_at'
	];

    public function oficinas(){
        return $this->hasMany(\App\Oficina::class, 'size_id');
	}
}
