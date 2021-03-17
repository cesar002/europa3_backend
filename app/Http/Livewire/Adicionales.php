<?php

namespace App\Http\Livewire;

use App\Adicional;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Adicionales extends Component
{

	public $adicionales = [], $edificios = [], $unidades = [];
	public $adicionalSelected;

	public function selectAdicional($adicional)
	{
		$this->adicionalSelected = $adicional;
	}

	public function update()
	{
		$this->validate([
			'adicionalSelected.edificio_id' => 'required',
			'adicionalSelected.unidad_id' => 'required',
			'adicionalSelected.nombre' => 'required',
			'adicionalSelected.cantidad_maxima' => 'required|integer|min:1',
			'adicionalSelected.precio' => 'required|numeric|min:1',
		], [], [
			'adicionalSelected.edificio_id' => 'edificio',
			'adicionalSelected.unidad_id' => 'unidad',
			'adicionalSelected.nombre' => 'nombre',
			'adicionalSelected.cantidad_maxima' => 'cantidad máxima',
			'adicionalSelected.precio' => 'precio',
		]);

		try {

			Adicional::findOrFail($this->adicionalSelected['id'])->update($this->adicionalSelected);

			$this->adicionales = Adicional::all();

			$this->emit('update-success', '');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Adicional actualizado'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al actualizar el adicional'
			]);
		}
	}

	public function delete($id)
	{
		try {
			Adicional::findOrFail($id)->delete();

			$this->adicionales = Adicional::all();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Adicional eliminado'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar el adicional'
			]);
		}
	}

    public function render()
    {
        return view('livewire.adicionales');
    }
}
