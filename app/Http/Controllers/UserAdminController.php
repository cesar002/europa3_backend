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
			$edificioModel = Edificio::findOrFail(1);

			$notificationsRaw = $edificioModel->notifications->all();

			$notifications = collect($notificationsRaw)->map(function($not){
				return[
					'id' => $not->id,
					'type' => $not->type,
					'created_at' => $not->created_at,
					'updated_at' => $not->updated_at,
					'read_at' => $not->read_at,
					'data' => $not->data
				];
			});

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
