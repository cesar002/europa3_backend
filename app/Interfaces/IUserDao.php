<?php

namespace App\Interfaces;

interface IUserDao{

	public function getUserData(\App\User $user);

	public function getUserDataById(int $userId);

}
