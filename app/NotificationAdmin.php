<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationAdmin extends Model
{
    protected $table = 'notifications_admin';

	protected $fillable = [
		'titulo', 'descripcion', 'data',
	];

	protected $hidden = [
		'updated_at',
	];

}

