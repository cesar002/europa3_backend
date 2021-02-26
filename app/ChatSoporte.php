<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatSoporte extends Model
{
	protected $table = 'chat_soporte';

	public function edificio(){
		return $this->belongsTo(\App\Edificio::class, 'edificio_id');
	}

	public function chatSoportable(){
		return $this->morphTo();
	}

}
