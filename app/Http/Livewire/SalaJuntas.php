<?php

namespace App\Http\Livewire;

use App\PathImage;
use App\SalaImage;
use App\Mobiliario;
use App\PathMaster;
use App\SalaServicio;
use App\SalaJuntas as SalaJuntasM;
use Livewire\Component;
use Illuminate\Support\Str;
use App\CatServiciosOficina;
use App\MobiliarioSalaJuntas;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SalaJuntas extends Component
{

	use WithFileUploads;

	public $salas, $edificios, $sizes, $servicios, $mobiliario = [];
	public $mobiliario_selected, $servicio_selected, $mobiliario_list = [], $servicios_list = [];
	public $edificio_id, $size_id, $nombre, $descripcion, $dimension, $precio, $capacidad_recomendada, $capacidad_maxima;
	public $images = [];

	public function fetchMobiliario()
	{
		try {
			$this->mobiliario = Mobiliario::where('edificio_id', $this->edificio_id)->get();

		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function submit()
	{
		$this->validate([
			'edificio_id' => 'required',
			'size_id' => 'required',
			'nombre' => 'required',
			'dimension' => 'required',
			'precio' => 'required|numeric|min:1',
			'capacidad_recomendada' => 'required|integer|min:1',
			'capacidad_maxima' => 'required|integer|gte:capacidad_recomendada',
			'servicios_list' => 'required|array|min:1',
			'mobiliario_list' => 'required|array|min:1',
			'mobiliario_list.*.cantidad' => 'required|integer|min:1|lte:mobiliario_list.*.maximo',
			'images' => 'required|array|min:1',
			'images.*' => 'required|image|max:10400',
		],[],[
			'edificio_id' => 'edificio',
			'size_id' => 'tamaño',
			'capacidad_recomendada' => 'capacidad recomendada',
			'capacidad_maxima' => 'capacidad máxima',
			'mobiliario_list.*.cantidad' => 'mobiliario'
		]);

		try {

			DB::beginTransaction();

			$pathMaster = PathMaster::findOrFail(2);
			$pathImage = new PathImage([
				'path_master_id' => 2,
				'nombre' => "Sala de juntas - {$this->nombre}",
				'path' => Str::random(rand(10, 50)),
			]);
			$pathImage->save();

			$salaJuntas = new SalaJuntasM([
				'edificio_id' => $this->edificio_id,
				'tipo_oficina_id' => 2,
				'size_id' => $this->size_id,
				'nombre' => $this->nombre,
				'descripcion' => $this->descripcion,
				'size_dimension' => $this->dimension,
				'capacidad_recomendada' => $this->capacidad_recomendada,
				'capacidad_maxima' => $this->capacidad_maxima,
				'precio' => $this->precio,
				'path_image_id' => $pathImage->id,
				'tipo_tiempo_id' => 2,
			]);
			$salaJuntas->save();

			foreach($this->servicios_list as $servicio){
				$serv = new SalaServicio([
					'sala_juntas_id' => $salaJuntas->id,
					'servicio_id' => $servicio['id'],
				]);

				$serv->save();
			}

			foreach($this->mobiliario_list as $mobiliario){
				$mob = Mobiliario::findOrFail($mobiliario['id']);
				$mobUsado = $mob->usado + $mobiliario['cantidad'];
				if($mobUsado > $mob->cantidad){
					throw new \Exception('La cantidad de mobiliario que se quiere asignar supera la cantidad que se tiene disponible');
				}
				$mob->usado = $mobUsado;
				$mob->save();

				$mobSala = new MobiliarioSalaJuntas([
					'sala_juntas_id' => $salaJuntas->id,
					'mobiliario_id' => $mobiliario['id'],
					'cantidad' => $mobiliario['cantidad'],
				]);

				$mobSala->save();
			}

			Storage::makeDirectory("{$pathMaster->path}/{$pathImage->path}");
			foreach($this->images as $image)
			{
				$img = $image->store("$pathMaster->path/$pathImage->path");

				$imageSala = new SalaImage([
					'sala_juntas_id' => $salaJuntas->id,
					'image' => basename($img),
				]);
				$imageSala->save();
			}

			DB::commit();

			$this->salas = SalaJuntasM::with('imagenes', 'pathImages', 'pathImages.pathMaster', 'edificio')->get();

			$this->emit('register-success', '');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Sala de juntas registrada con éxito'
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar la sala de juntas'
			]);
		}
	}

	public function addNewServicio()
	{
		try {
			$servicio = CatServiciosOficina::findOrFail($this->servicio_selected);
			array_push($this->servicios_list, $servicio->toArray());
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function removeNewServicio($index)
	{
		unset($this->servicios_list[$index]);
	}

	public function addNewMobiliario()
	{
		$mobiliario = Mobiliario::findOrFail($this->mobiliario_selected);
		$newMobiliario = [
			'id' => $mobiliario->id,
			'nombre' => $mobiliario->nombre,
			'cantidad' => 1,
			'maximo' => ($mobiliario->cantidad - $mobiliario->usado),
		];

		array_push($this->mobiliario_list, $newMobiliario);
	}

	public function removeNewMobiliario($index)
	{
		unset($this->mobiliario_list[$index]);
	}


	public function delete($id)
	{
		try {

			SalaJuntasM::findOrFail($id)->delete();

			$this->salas = SalaJuntasM::with('imagenes', 'pathImages', 'pathImages.pathMaster', 'edificio')->get();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Sala de juntas eliminada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar la sala de juntas'
			]);

		}
	}


    public function render()
    {
        return view('livewire.sala-juntas');
    }
}
