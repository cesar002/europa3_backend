<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRecepcion extends Model
{
	protected $table = 'chat_recepcion';

	public function user(){
		return $this->belongsTo(\App\User::class);
	}

	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

}
