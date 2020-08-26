<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoUserRegister extends Model
{
	protected $table = 'no_users_registers';


	public function chatSoporte(){
		return $this->morphToMany(\App\ChatSoporte::class, 'usertable');
	}
}
