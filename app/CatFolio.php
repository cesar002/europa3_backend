<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatFolio extends Model
{
	protected $table = 'cat_folios';

	protected $hidden = [
		'created_at', 'updated_at',
	];
}
