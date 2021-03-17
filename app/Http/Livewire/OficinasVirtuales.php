<?php

namespace App\Http\Livewire;

use App\OficinaVirtual;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class OficinasVirtuales extends Component
{
	public $oficinasVirtuales, $oficinaSelected, $edificios;

	public function setOficina(OficinaVirtual $oficina)
	{
		$this->oficinaSelected = $oficina->toArray();
	}

	public function update()
	{
		$data = $this->validate([
			'oficinaSelected.edificio_id' => 'required',
			'oficinaSelected.descripcion' => 'nullable',
			'oficinaSelected.nombre' => 'required',
			'oficinaSelected.precio' => 'required|numeric|min:1',
		],[],[
			'oficinaSelected.edificio_id' => 'edificio',
			'oficinaSelected.nombre' => 'nombre',
			'oficinaSelected.precio' => 'precio',
		]);

		try {

			OficinaVirtual::findOrFail($this->oficinaSelected['id'])->update($data['oficinaSelected']);

			$this->oficinasVirtuales = OficinaVirtual::with('edificio')->get();

			$this->emit('update-success', '');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Información actualizada con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al actualizar la información'
			]);
		}
	}

	public function delete($idOficina)
	{
		try {

			OficinaVirtual::findOrFail($idOficina)->delete();

			$this->oficinasVirtuales = OficinaVirtual::with('edificio')->get();
		} catch (\Throwable $th) {
			Log::error($th->getMessage);

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar la oficina virtual'
			]);
		}
	}

    public function render()
    {
        return view('livewire.oficinas-virtuales');
    }
}
