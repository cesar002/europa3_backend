<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

	private $userRepository;

	public function __construct(\App\Repositories\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Obtiene la información del usuario actualmente logueado
	 */
	public function getCurrentAuthUser(Request $request){
		$userData = $this->userRepository->getUserData($request->user());

		return response(json_encode($userData, JSON_FORCE_OBJECT));
	}

	public function getAllUsuarios(){
		$usuarios = $this->userRepository->getAll();

		return response($usuarios);
	}
}
