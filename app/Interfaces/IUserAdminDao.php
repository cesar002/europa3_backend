<?php

namespace App\Interfaces;

interface IUserAdminDao{


	public function getAllUsers();

	public function getUserData(\App\UserAdmin $user);

	public function getUserDataById($id);

	public function getEdificioUser($id);

}
