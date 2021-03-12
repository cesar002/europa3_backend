<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\CatIdiomasAtencion;
use Illuminate\Support\Facades\Log;

class IdiomasAtencion extends Component
{

	public $idioma;
	public $idiomas = [];
	public $idiomaSelected;

	public function mount()
	{
		$this->idiomas = CatIdiomasAtencion::get();
	}


	public function updateIdioma()
	{
		$this->validate([
			'idiomaSelected.idioma' => 'required|string'
		], [],
		[
			'idiomaSelected.idioma' => 'idioma'
		]);

		try {

			CatIdiomasAtencion::findOrFail($this->idiomaSelected['id'])->update([
				'idioma' => $this->idiomaSelected['idioma'],
			]);

			$this->idiomas = CatIdiomasAtencion::get();

			$this->emit('UPDATE_SUCCESS', '');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Actualización éxitosa',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al actualizar la información',
			]);
		}
	}

	public function delete($id)
	{
		try {
			CatIdiomasAtencion::findOrFail($id)->delete();

			$this->idiomas = CatIdiomasAtencion::get();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Idioma eliminado',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar el idioma',
			]);
		}
	}

	public function submit()
	{
		$this->validate([
			'idioma' => 'required|string',
		]);

		try {

			$idioma = new CatIdiomasAtencion([
				'idioma' => $this->idioma,
			]);
			$idioma->save();

			$this->idiomas = CatIdiomasAtencion::get();

			$this->reset('idioma');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Idioma registrado con éxito',
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Error al registrar el idioma',
			]);
		}
	}

    public function render()
    {
        return view('livewire.idiomas-atencion');
    }
}
