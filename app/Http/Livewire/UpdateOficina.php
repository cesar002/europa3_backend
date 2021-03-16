<?php

namespace App\Http\Livewire;

use App\Oficina;
use App\Mobiliario;
use Livewire\Component;
use App\OficinaServicio;
use App\MobiliarioOficina;
use App\CatServiciosOficina;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateOficina extends Component
{
	public $oficina, $edificios = [], $sizes = [], $servicios = [], $mobiliario = [];
	public $servicio_selected, $mobiliario_selected, $mobiliario_deleted = [];
	public $images = [];

	public function update()
	{

		$this->validate([
			'oficina.edificio_id' => 'required',
			'oficina.size_id' => 'required',
			'oficina.nombre' => 'required',
			'oficina.size_dimension' => 'required',
			'oficina.capacidad_recomendada' => 'required|integer|min:1',
			'oficina.capacidad_maxima' => 'required|integer|gte:oficina.capacidad_recomendada',
			'oficina.precio' => 'required|numeric',
			'oficina.servicios' => 'required|array|min:1',
			'oficina.mobiliario_asignado' => 'required|array|min:1',
		], [], [
			'oficina.edificio_id' => 'edificio',
			'oficina.size_id' => 'tamaño',
			'oficina.size_dimension' => 'dimensiones',
			'oficina.capacidad_recomendada' => 'capacidad recomendada',
			'oficina.capacidad_maxima' => 'capacidad máxima',
			'oficina.servicios' => 'servicios',
			'oficina.mobiliario_asignado' => 'mobiliario',
		]);

		try {

			DB::beginTransaction();

			$oficina = Oficina::findOrFail($this->oficina['id']);
			$oficina->update([
				'edificio_id' => $this->oficina['edificio_id'],
				'size_id' => $this->oficina['size_id'],
				'nombre' => $this->oficina['nombre'],
				'descripcion' => $this->oficina['descripcion'],
				'size_dimension' => $this->oficina['size_dimension'],
				'capacidad_recomendada' => $this->oficina['capacidad_recomendada'],
				'capacidad_maxima' => $this->oficina['capacidad_maxima'],
				'precio' => $this->oficina['precio'],
			]);

			DB::table('oficina_servicios')->where('oficina_id', $oficina->id)->delete();

			foreach($this->oficina['servicios'] as $servicio)
			{
				$serv = new OficinaServicio([
					'oficina_id' => $oficina->id,
					'servicio_id' => $servicio['id'],
				]);

				$serv->save();
			}

			foreach($this->oficina['mobiliario_asignado'] as $mobiliario)
			{
				$mobiOfi = MobiliarioOficina::find($mobiliario['id']);
				$_mobiliario = Mobiliario::findOrFail($mobiliario['mobiliario_id']);
				if($mobiOfi != null){
					$_mobiliario->usado = $_mobiliario->usado - $mobiOfi->cantidad;
					$_mobiliario->save();
				}

				$mobi = MobiliarioOficina::updateOrCreate([
					'id' => $mobiliario['id'],
					'oficina_id' => $this->oficina['id'],
					'mobiliario_id' => $mobiliario['mobiliario_id'],
				], [
					'oficina_id' => $this->oficina['id'],
					'mobiliario_id' => $mobiliario['mobiliario_id'],
					'cantidad' => $mobiliario['cantidad'],
				]);

				$_mobiliario->usado = $_mobiliario->usado + $mobi->cantidad;
				if($_mobiliario->usado > $_mobiliario->cantidad){ throw new \Exception('La cantidad de mobiliario que se quiere asignar supera la cantidad que se tiene disponible'); }
				$_mobiliario->save();
			}

			$data = collect($this->oficina['mobiliario_asignado'])->map(function($data){ return $data['mobiliario_id']; });
			$_mobiliario  = MobiliarioOficina::where('oficina_id', $this->oficina['id'])->whereNotIn('mobiliario_id', $data->all())->get();
			foreach($_mobiliario as $m)
			{
				$_m = Mobiliario::findOrFail($m->mobiliario_id);
				$_m->usado = $_m->usado - $m->cantidad;
				$_m->save();
			}
			DB::table('mobiliario_oficina')->where('oficina_id', $this->oficina['id'])->whereNotIn('mobiliario_id', $data->all())->delete();

			$this->oficina = Oficina::with('mobiliarioAsignado', 'mobiliarioAsignado.mobiliario', 'servicios')->findOrFail($oficina->id)->toArray();

			$this->emit('update', [
				'status' => 'success',
				'message' => 'Información actualizada con éxito'
			]);

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			$this->emit('update', [
				'status' => 'error',
				'message' => 'Ocurrió un error al actualizar la información'
			]);
		}
	}

	public function addServicios()
	{
		try {
			$servicio = CatServiciosOficina::findOrFail($this->servicio_selected);

			array_push($this->oficina['servicios'], [
				'id' => $servicio->id,
				'servicio' => $servicio->servicio,
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function removeServicio($index)
	{
		unset($this->oficina['servicios'][$index]);
	}

	public function addMobiliario()
	{
		try {
			$mobiliario = Mobiliario::findOrFail($this->mobiliario_selected);
			array_push($this->oficina['mobiliario_asignado'], [
				'id' => -1,
				'oficina_id' => $this->oficina['id'],
				'mobiliario_id' => $mobiliario->id,
				'mobiliario' => [
					'nombre' => $mobiliario->nombre,
				],
				'cantidad' => 1,
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
		}
	}

	public function removeMobiliario($index)
	{
		unset($this->oficina['mobiliario_asignado'][$index]);
	}

	public function fetchMobiliario()
	{
		$this->mobiliario = Mobiliario::where('edificio_id', $this->oficina['edificio_id'])->get();
	}

    public function render()
    {
        return view('livewire.update-oficina');
    }
}
