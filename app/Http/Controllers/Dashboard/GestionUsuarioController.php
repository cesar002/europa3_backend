<?php

namespace App\Http\Controllers\Dashboard;

use App\UserAdmin;
use Illuminate\Http\Request;
use App\UserAdminPersonalData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserAdminRequest;
use App\Http\Requests\RegisterUserAdminRequest;

class GestionUsuarioController extends Controller
{
    public function index()
	{
		$usuarios = UserAdmin::all();

		return view('dashboard.gestionUsuarios.home', [
			'usuarios' => $usuarios
		]);
	}

	public function store(RegisterUserAdminRequest $request)
	{
		try {

			DB::beginTransaction();


			$user = new UserAdmin([
				'username' => $request->username,
				'password' => Hash::make($request->password),
			]);
			$user->save();

			$userData = new UserAdminPersonalData();
			$userData->user_admin_id = $user->id;
			$userData->path_id = 1;
			$userData->nombre = $request->nombre;
			$userData->ap_p = $request->ap_p;
			$userData->ap_m = $request->ap_m;
			$userData->save();

			$paths = $userData->pathImage()->with('pathMaster')->first();
			if(!is_null($request->file('avatar'))){
				$image_saved = Storage::put("{$paths->pathMaster->path}/{$paths->path}", $request->file('avatar'));
				$userData->avatar_image = basename($image_saved);
				$userData->save();
			}

			DB::commit();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Usuario registrado con éxito',
			]);

		} catch (\Throwable $th) {
			DB::rollback();
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar el usuario',
			]);
		}finally{
			return redirect()->back();
		}
	}

	public function show($id)
	{
		try {

			$usuario = UserAdmin::with('infoPersonal')->findOrFail($id);

			return view('dashboard.gestionUsuarios.show', [
				'usuario' => $usuario
			]);
		} catch (\Throwable $th) {
			return abort(404);
		}
	}

	public function update(UpdateUserAdminRequest $request, $id)
	{
		try {

			DB::beginTransaction();

			UserAdmin::findOrFail($id)->update([
				'username' => $request->username
			]);

			$userData = UserAdminPersonalData::where('user_admin_id', $id)->first();
			$paths = $userData->pathImage()->with('pathMaster')->first();
			if(!is_null($request->file('avatar'))){
				$image_saved = Storage::put("{$paths->pathMaster->path}/{$paths->path}", $request->file('avatar'));
				$userData->avatar_image = basename($image_saved);
				$userData->save();
			}
			$userData->nombre = $request->nombre;
			$userData->ap_p = $request->ap_p;
			$userData->ap_m = $request->ap_m;
			$userData->save();

			DB::commit();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Información actualizada',
			]);
		} catch (\Throwable $th) {
			DB::rollback();

			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al actualizar el usuario',
			]);

		}finally{
			return redirect()->back();
		}
	}

}
