<?php

namespace App\Http\Livewire;

use App\CatServiciosOficina;
use App\Mobiliario;
use App\MobiliarioSala;
use App\SalaJuntas as SalaJuntasM;
use App\SalaServicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SalaJuntasUpdate extends Component
{

	public $sala, $edificios, $sizes, $servicios, $mobiliario = [];
	public $servicio_selected, $mobiliario_selected, $mobiliario_list = [];

	public function mount()
	{

		$this->mobiliario = Mobiliario::where('edificio_id', $this->sala['edificio_id'])->get();

		$algo = collect($this->sala['mobiliario_asignado'])->map(function($m){
			return [
				'id' => $m['id'],
				'mobiliario_id' => $m['mobiliario_id'],
				'nombre' => $m['mobiliario']['nombre'],
				'cantidad' => $m['cantidad'],
				'maximo' => $m['mobiliario']['cantidad'] - $m['mobiliario']['usado'],
			];
		});

		$this->mobiliario_list = $algo->all();
	}

	public function fetchMobiliario()
	{
		try {

			$this->mobiliario_list = [];

			$this->mobiliario = Mobiliario::where('edificio_id', $this->sala['edificio_id'])->get();
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function removeNewMobiliario($index)
	{
		unset($this->mobiliario_list[$index]);
	}

	public function addNewMobiliario()
	{
		try {
			$mobiliario = Mobiliario::findOrFail($this->mobiliario_selected);
			array_push($this->mobiliario_list, [
				'id' => -1,
				'mobiliario_id' => $mobiliario->id,
				'nombre' => $mobiliario->nombre,
				'cantidad' => 1,
				'maximo' => $mobiliario->cantidad - $mobiliario->usado,
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function addNewServicio()
	{
		try {
			$servicio = CatServiciosOficina::findOrFail($this->servicio_selected);
			array_push($this->sala['servicios'], [
				'id' => $servicio->id,
				'servicio' => $servicio->servicio,
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function removeNewServicio($index)
	{
		unset($this->sala['servicios'][$index]);
	}

	public function submit()
	{
		$this->validate([
			'sala.edificio_id' => 'required',
			'sala.size_id' => 'required',
			'sala.nombre' => 'required',
			'sala.size_dimension' => 'required',
			'sala.precio' => 'required|numeric|min:1',
			'sala.capacidad_recomendada' => 'required|integer|min:1',
			'sala.capacidad_maxima' => 'required|integer|gte:sala.capacidad_recomendada',
			'sala.servicios' => 'required|array|min:1',
			'mobiliario_list' => 'required|array|min:1',
			'mobiliario_list.*.cantidad' => 'required|integer|min:1|lte:mobiliario_list.*.maximo',
		],[],[
			'sala.edificio_id' => 'edificio',
			'sala.size_id' => 'tamaño',
			'sala.nombre' => 'nombre',
			'sala.size_dimension' => 'dimension',
			'sala.precio' => 'precio',
			'sala.capacidad_recomendada' => 'capacidad recomendada',
			'sala.capacidad_maxima' => 'capacidad máxima',
			'sala.servicios' => 'servicios',
			'mobiliario_list.*.cantidad' => 'mobiliario'
		]);

		try {

			DB::beginTransaction();

			$sala = SalaJuntasM::findOrFail($this->sala['id']);
			$sala->update([
				'edificio_id' => $this->sala['edificio_id'],
				'size_id' => $this->sala['size_id'],
				'nombre' => $this->sala['nombre'],
				'descripcion' => $this->sala['descripcion'],
				'size_dimension' => $this->sala['size_dimension'],
				'precio' => $this->sala['precio'],
				'capacidad_recomendada' => $this->sala['capacidad_recomendada'],
				'capacidad_maxima' => $this->sala['capacidad_maxima'],
			]);

			DB::table('sala_juntas_servicios')->where('sala_juntas_id', $sala->id)->delete();
			foreach($this->sala['servicios'] as $servicio)
			{
				$serv = new SalaServicio([
					'sala_juntas_id' => $sala->id,
					'servicio_id' => $servicio['id'],
				]);

				$serv->save();
			}

			foreach($this->mobiliario_list as $mobiliario)
			{
				$mobiOfi = MobiliarioSala::find($mobiliario['id']);
				$_mobiliario = Mobiliario::findOrFail($mobiliario['mobiliario_id']);
				if($mobiOfi != null){
					$_mobiliario->usado = $_mobiliario->usado - $mobiOfi->cantidad;
					$_mobiliario->save();
				}

				$mobi = MobiliarioSala::updateOrCreate([
					'id' => $mobiliario['id'],
					'sala_juntas_id' => $this->sala['id'],
					'mobiliario_id' => $mobiliario['mobiliario_id'],
				], [
					'sala_juntas_id' => $this->sala['id'],
					'mobiliario_id' => $mobiliario['mobiliario_id'],
					'cantidad' => $mobiliario['cantidad'],
				]);

				$_mobiliario->usado = $_mobiliario->usado + $mobi->cantidad;
				if($_mobiliario->usado > $_mobiliario->cantidad){ throw new \Exception('La cantidad de mobiliario que se quiere asignar supera la cantidad que se tiene disponible'); }
				$_mobiliario->save();
			}
			$data = collect($this->mobiliario_list)->map(function($data){ return $data['mobiliario_id']; });
			$_mobiliario  = MobiliarioSala::where('sala_juntas_id', $this->sala['id'])->whereNotIn('mobiliario_id', $data->all())->get();
			foreach($_mobiliario as $m)
			{
				$_m = Mobiliario::findOrFail($m->mobiliario_id);
				$_m->usado = $_m->usado - $m->cantidad;
				$_m->save();
			}
			DB::table('mobiliario_sala_juntas')->where('sala_juntas_id', $this->sala['id'])->whereNotIn('mobiliario_id', $data->all())->delete();

			$this->sala = SalaJuntasM::with('servicios', 'mobiliarioAsignado', 'mobiliarioAsignado.mobiliario')->findOrFail($sala->id)->toArray();
			$algo = collect($this->sala['mobiliario_asignado'])->map(function($m){
				return [
					'id' => $m['id'],
					'mobiliario_id' => $m['mobiliario_id'],
					'nombre' => $m['mobiliario']['nombre'],
					'cantidad' => $m['cantidad'],
					'maximo' => $m['mobiliario']['cantidad'] - $m['mobiliario']['usado'],
				];
			});

			$this->mobiliario_list = $algo->all();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Información actualizada con éxito'
			]);

			DB::commit();
		} catch (\Throwable $th) {

			DB::rollBack();

			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al actualizar la información'
			]);
		}
	}

    public function render()
    {
        return view('livewire.sala-juntas-update');
    }
}
