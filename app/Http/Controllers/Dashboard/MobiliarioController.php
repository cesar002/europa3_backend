<?php

namespace App\Http\Controllers\Dashboard;

use App\Edificio;
use App\PathImage;
use App\Mobiliario;
use App\TipoMobiliario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MobiliarioStoreRequest;
use App\Http\Requests\MobiliarioUpdateRequest;
use Illuminate\Support\Facades\Log;

class MobiliarioController extends Controller
{
    public function index()
	{
		$mobiliario = Mobiliario::with('pathImages', 'pathImages.pathMaster', 'edificio')->get();
		$edificios = Edificio::all();
		$tiposMueble = TipoMobiliario::all();

		return view('dashboard.mobiliario.home', [
			'mobiliario' => $mobiliario,
			'edificios' => $edificios,
			'tiposMueble' => $tiposMueble,
		]);
	}

	public function show($id)
	{
		try {
			$mobiliario = Mobiliario::findOrFail($id);
			$edificios = Edificio::all();
			$tiposMueble = TipoMobiliario::all();

			return view('dashboard.mobiliario.show', [
				'mobiliario' => $mobiliario,
				'edificios' => $edificios,
				'tiposMueble' => $tiposMueble,
			]);
		} catch (\Throwable $th) {
			return abort(404);
		}
	}

	public function store(MobiliarioStoreRequest $request)
	{
		try {
			$pathMobiliario = PathImage::with('pathMaster')->findOrFail(2);

			$image_inserted = Storage::put("{$pathMobiliario->pathMaster->path}/{$pathMobiliario->path}", $request->image);

			$mobiliario = new Mobiliario([
				'tipo_id' => $request->tipo_mueble_id,
				'edificio_id' => $request->edificio_id,
				'path_id' => 2,
				'nombre' => $request->nombre,
				'marca' => $request->marca ?? 'S/N',
				'modelo' => $request->modelo ?? 'S/N',
				'color' => $request->color ?? 'S/N',
				'descripcion_bien' => $request->descripcion_bien,
				'observaciones' => $request->observaciones,
				'cantidad' => $request->cantidad,
				'image' => basename($image_inserted),
			]);

			$mobiliario->save();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Mobiliario guardado con éxtio'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar el mobiliario'
			]);
		}finally{
			return redirect()->back();
		}
	}

	public function update(MobiliarioUpdateRequest $request, $id)
	{
		try {

			$mobiliario = Mobiliario::with('pathImages', 'pathImages.pathMaster')->findOrFail($id);

			$mobiliario->tipo_id = $request->tipo_id;
			$mobiliario->edificio_id = $request->edificio_id;
			$mobiliario->nombre = $request->nombre;
			$mobiliario->marca = $request->marca;
			$mobiliario->modelo = $request->modelo;
			$mobiliario->color = $request->color;
			$mobiliario->descripcion_bien = $request->descripcion_bien;
			$mobiliario->observaciones = $request->observaciones;
			$mobiliario->cantidad = $request->cantidad;
			$mobiliario->activo = $request->activo ? true : false;

			if(!empty($request->image)){
				$path = "{$mobiliario->pathImages->pathMaster->path}/{$mobiliario->pathImages->path}";
				$oldImage = $mobiliario->image;

				$newImage = Storage::put($path, $request->image);

				$mobiliario->image = basename($newImage);

				Storage::delete("{$path}/{$oldImage}");
			}

			$mobiliario->save();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Actualización éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al actualizar el mobiliario'
			]);
		}finally{
			return redirect()->back();
		}
	}

}
