<?php

namespace App\Http\Livewire;

use App\CatIdiomasAtencion;
use App\Edificio;
use App\EdificioIdiomasAtencion;
use App\Estado;
use App\Municipio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EdificiosUpdate extends Component
{

	public $edificio;
	public $estados = [], $municipios = [], $idiomas = [], $idiomaSelected;

	public function mount()
	{
		$this->idiomas = CatIdiomasAtencion::all();
		$this->estados = Estado::all();
		$this->municipios = Municipio::where('estado_id', $this->edificio['municipio']['estado']['id'])->orderBy('nombre', 'ASC')->get();
	}

	public function getMunicipios()
	{
		$this->municipios =  Municipio::where('estado_id', $this->edificio['municipio']['estado']['id'])->orderBy('nombre', 'ASC')->get();
	}

	public function addIdioma()
	{
		try {
			$idioma = CatIdiomasAtencion::findOrFail($this->idiomaSelected);
			array_push($this->edificio['idiomas'], $idioma);
		} catch (\Throwable $th) {}
	}

	public function removeIdioma($index)
	{
		unset($this->edificio['idiomas'][$index]);
	}

	public function submit()
	{
		$this->validate([
			'edificio.nombre' => 'required',
			'edificio.direccion' => 'required',
			'edificio.municipio_id' => 'required',
			'edificio.telefono_1' => 'required',
			'edificio.telefono_recepcion' => 'required',
			'edificio.hora_apertura' => 'required',
			'edificio.hora_cierre' => 'required',
			'edificio.idiomas' => 'required|array|min:1'
		], [], [
			'edificio.municipio_id' => 'municipio',
			'edificio.telefono_1' => 'teléfono 1',
			'edificio.telefono_recepcion' => 'teléfono recepcion',
			'edificio.hora_apertura' => 'hora de apertura',
			'edificio.hora_cierre' => 'hora de cierre',
			'edificio.idiomas' => 'idiomas'
		]);

		try {
			DB::beginTransaction();

			Edificio::findOrFail($this->edificio['id'])->update([
				'nombre' => $this->edificio['nombre'],
				'direccion' => $this->edificio['direccion'],
				'municipio_id' => $this->edificio['municipio_id'],
				'telefono_1' => $this->edificio['telefono_1'],
				'telefono_recepcion' => $this->edificio['telefono_recepcion'],
				'hora_apertura' => $this->edificio['hora_apertura'],
				'hora_cierre' => $this->edificio['hora_cierre'],
			]);

			DB::table('edificio_idiomas_atencion')->where('edificio_id', $this->edificio['id'])->delete();
			foreach ($this->edificio['idiomas'] as $idioma) {
				EdificioIdiomasAtencion::create([
					'edificio_id' => $this->edificio['id'],
					'idioma_id' => $idioma['id'],
				]);
			}

			DB::commit();

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Información actualizada con éxito'
			]);
		} catch (\Throwable $th) {

			DB::rollBack();

			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un erro al actualizar la información'
			]);
		}
	}

    public function render()
    {
        return view('livewire.edificios-update');
    }
}
