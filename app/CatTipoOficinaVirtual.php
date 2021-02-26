<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatTipoOficinaVirtual extends Model
{
	protected $table = 'cat_tipo_oficina_virtual';

	protected $hidden = [
		'created_at', 'updated_at',
	];
}
