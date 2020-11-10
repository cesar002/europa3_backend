<?php

namespace App\Http\Controllers;

use App\Edificio;
use App\UserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAdminController extends Controller{

	private $userAdminRepository;

	public function __construct(\App\Repositories\UserAdminRepository $userAdminRepository){
		$this->userAdminRepository = $userAdminRepository;
	}

	public function getDataCurrenUser(Request $request){
		try {
			$user = $request->user('api-admin');

			$data = $this->userAdminRepository->getUserData($user);

			return response($data);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'No se pudo obtener la información del usuario logueado'
			], 500);
		}
	}

	public function getNotifications(Request $request){
		try {
			$edificio = $this->userAdminRepository->getEdificioUser($request->user('api-admin')->id);

			$edificioModel = Edificio::findOrFail($edificio['id']);

			$notifications = $edificioModel->notifications->all();

			return response($notifications);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return [];
		}
	}

	public function index(){

	}

	public function personalDataRegister(){

	}

	public function show(){

	}

	public function update(){

	}

}
