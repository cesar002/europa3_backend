<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\CatServiciosOficina;
use Illuminate\Support\Facades\Log;

class Servicios extends Component
{
	public $servicios = [];
	public $newServicio;
	public $servicioSelected;

	public $rules = [
		'servicioSelected.servicio' => 'required'
	];

	public function submit()
	{
		$this->validate([
			'newServicio' => 'required'
		]);

		try {
			$servicio = new CatServiciosOficina();
			$servicio->servicio = $this->newServicio;
			$servicio->save();

			$this->servicios = CatServiciosOficina::all();

			$this->reset('newServicio');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Servicio registrado'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar el servicio'
			]);
		}
	}

	public function selectServicio($index)
	{
		$this->servicioSelected = $this->servicios[$index];
	}

	public function update()
	{

		$this->validate([
			'servicioSelected.servicio' => 'required'
		]);

		try{
			CatServiciosOficina::findOrFail($this->servicioSelected['id'])->update([
				'servicio' => $this->servicioSelected['servicio']
			]);

			$this->servicios = CatServiciosOficina::all();

			$this->emit('UPDATE_SUCCESS', '');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Información actualizada'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al actualizar el servicio'
			]);
		}
	}

	public function delete($id)
	{
		try{

			CatServiciosOficina::findOrFail($id)->delete();

			$this->servicios = CatServiciosOficina::all();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Servicio eliminado'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar el servicio'
			]);
		}
	}

    public function render()
    {
        return view('livewire.servicios');
    }
}
