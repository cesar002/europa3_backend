<?php

namespace App\Http\Livewire;

use App\Oficina;
use App\PathImage;
use App\Mobiliario;
use App\PathMaster;
use App\OficinaImage;
use Livewire\Component;
use App\OficinaServicio;
use App\MobiliarioOficina;
use Illuminate\Support\Str;
use App\CatServiciosOficina;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Oficinas extends Component
{

	use WithFileUploads;

	public $oficinas = [], $edificios = [], $sizes = [], $servicios = [], $mobiliario = [];
	public $mobiliario_selected, $servicio_selected;
	public $serviciosSelected = [], $mobiliarioSelected = [];
	public $edificio_id, $size_id, $nombre, $descripcion, $dimensiones, $capacidad_recomendada, $capacidad_maxima, $precio;
	public $images = [];

	public function fetchMobiliario()
	{
		$this->mobiliario = Mobiliario::where('edificio_id', $this->edificio_id)->get();
	}

	public function addMobiliario()
	{
		try {

			$mobiliario = Mobiliario::findOrFail($this->mobiliario_selected);

			array_push($this->mobiliarioSelected, [
				'id' => $mobiliario->id,
				'nombre' => $mobiliario->nombre,
				'cantidad' => 1,
			]);

		} catch (\Throwable $th) {
			Log::error('message');
		}
	}

	public function removeMobiliario($id)
	{
		unset($this->mobiliarioSelected[$id]);
	}

	public function addServicios()
	{
		try {
			$servicio = CatServiciosOficina::findORFail($this->servicio_selected);

			array_push($this->serviciosSelected, [
				'id' => $servicio->id,
				'nombre' => $servicio->servicio,
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function removeServicio($id)
	{
		unset($this->serviciosSelected[$id]);
	}

	public function submit()
	{
		$this->validate([
			'edificio_id' => 'required',
			'size_id' => 'required',
			'nombre' => 'required',
			'dimensiones' => 'required',
			'capacidad_recomendada' => 'required|integer|min:1',
			'capacidad_maxima' => 'required|integer|gte:capacidad_recomendada',
			'precio' => 'required|numeric',
			'images'  => 'required|array|min:1',
			'images.*' => 'image|max:10300',
			'serviciosSelected' => 'required|array|min:1',
			'mobiliarioSelected' => 'required|array|min:1',
		], [], [
			'edificio_id' => 'edificio',
			'size_id' => 'tamaño',
			'capacidad_recomendada' => 'capacidad recomendada',
			'capacidad_maxima' => 'capacidad máxima',
			'images'  => 'imagenes',
			'images.*' => 'imagen',
			'serviciosSelected' => 'servicios',
			'mobiliarioSelected' => 'mobiliario',
		]);

		try {
			DB::beginTransaction();

			$pathMaster = PathMaster::findOrFail(2);

			$pathImage = new PathImage([
				'path_master_id' => 2,
				'nombre' => "Oficina - {$this->nombre}",
				'path' => Str::random(rand(10, 50)),
			]);
			$pathImage->save();

			$oficina = new Oficina([
				'edificio_id' => $this->edificio_id,
				'tipo_oficina_id' => 1,
				'tipo_tiempo_id' => 1,
				'size_id' => $this->size_id,
				'nombre' => $this->nombre,
				'descripcion' => $this->descripcion,
				'size_dimension' => $this->dimensiones,
				'capacidad_recomendada' => $this->capacidad_recomendada,
				'capacidad_maxima' => $this->capacidad_maxima,
				'precio' => $this->precio,
				'path_image_id' => $pathImage->id
			]);
			$oficina->save();

			foreach($this->mobiliarioSelected as $index => $mobiliario){
				$mob = Mobiliario::findOrFail($mobiliario['id']);
				$mobUsado = $mob->usado + $mobiliario['cantidad'];
				if($mobUsado > $mob->cantidad){
					throw new \Exception('La cantidad de mobiliario que se quiere asignar supera la cantidad que se tiene disponible');
				}
				$mob->usado = $mobUsado;
				$mob->save();

				$mobOficina = new MobiliarioOficina([
					'oficina_id' => $oficina->id,
					'mobiliario_id' => $mobiliario['id'],
					'cantidad' => $mobiliario['cantidad'],
				]);

				$mobOficina->save();
			}

			foreach($this->serviciosSelected as $servicio){
				$serv = new OficinaServicio([
					'oficina_id' => $oficina->id,
					'servicio_id' => $servicio['id'],
				]);

				$serv->save();
			}

			Storage::makeDirectory("{$pathMaster->path}/{$pathImage->path}");
			foreach($this->images as $image){
				$nameImage = $image->store("$pathMaster->path/$pathImage->path");
				// $nameImage = Storage::put("$pathMaster->path/$pathImage->path", $image);

				$imageOficina = new OficinaImage([
					'oficina_id' => $oficina->id,
					'image' => basename($nameImage),
				]);

				$imageOficina->save();
			}


			DB::commit();

			$this->oficinas = Oficina::all();

			$this->emit('register-success', '');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Oficina registrada con éxito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar la oficina'
			]);
		}

	}

	public function delete($idOficina)
	{
		try {
			Oficina::findOrFail($idOficina)->delete();

			$this->oficinas = Oficina::all();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Oficina eliminada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar la oficina'
			]);
		}
	}

    public function render()
    {
        return view('livewire.oficinas');
    }
}
