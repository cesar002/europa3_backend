<?php

namespace App\Http\Controllers;

use App\Repositories\UserAdminRepository;
use Illuminate\Http\Request;

class GestionUsuariosSystemController extends Controller
{
	private $userAdminRepository;

	public function __construct(UserAdminRepository $userAdminRepository)
	{
		$this->userAdminRepository = $userAdminRepository;
	}

    public function index()
	{
		try {
			$users = $this->userAdminRepository->getAllUsers();

			return response($users);
		} catch (\Throwable $th) {
			return response([]);
		}
	}


}
