<?php

namespace App\Http\Livewire;

use App\Estado;
use App\Edificio;
use App\Municipio;
use Livewire\Component;
use App\CatIdiomasAtencion;
use App\EdificioIdiomasAtencion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Edificios extends Component
{
	public $edificios = [];
	public $estados = [], $municipios = [], $idiomas = [];
	public $estado_id, $municipio_id, $idiomaSelected;
	public $idiomasSelected = [];
	public $nombre, $direccion, $telefono_1, $telefono_2, $telefono_recepcion, $hora_apertura, $hora_cierre;

	public function mount()
	{
		$this->estados = Estado::all();
		$this->idiomas = CatIdiomasAtencion::all();
	}

	public function removeIdioma($i)
	{
		unset($this->idiomasSelected[$i]);
	}

	public function addIdioma()
	{
		try{

			$idioma = CatIdiomasAtencion::findOrFail($this->idiomaSelected);

			array_push($this->idiomasSelected, $idioma->toArray());
		}catch(\Throwable $th){
			Log::error($th->getMessage());
		}
	}

	public function getMunicipios()
	{
		$this->municipios = Municipio::where('estado_id', $this->estado_id)->orderBy('nombre', 'asc')->get();
	}

	public function submit()
	{
		$this->validate([
			'nombre' => 'required',
			'direccion' => 'required',
			'estado_id' => 'required|numeric',
			'municipio_id' => 'required|numeric',
			'telefono_1' => 'required',
			'telefono_recepcion' => 'required',
			'hora_apertura' => 'required',
			'hora_cierre' => 'required',
			'idiomasSelected' => 'required|array|min:1',
		], [], [
			'estado_id' => 'estado',
			'municipio_id' => 'municipio',
			'telefono_1'  => 'teléfono',
			'telefono_recepcion' => 'teléfono de recepción',
			'hora_apertura' => 'hora de apertura',
			'hora_cierre' => 'hora de cierre',
			'idiomasSelected' => 'idiomas de atención'
		]);

		try {

			DB::beginTransaction();

			$edificio = Edificio::create([
				'nombre' => $this->nombre,
				'direccion' => $this->direccion,
				'municipio_id' => $this->municipio_id,
				'telefono_1' => $this->telefono_1,
				'telefono_recepcion' => $this->telefono_recepcion,
				'hora_apertura' => $this->hora_apertura,
				'hora_cierre' => $this->hora_cierre,
			]);
			if(is_null($edificio)){ throw new \Exception('Error al crear el objeto edificio'); }

			foreach($this->idiomasSelected as $idioma){
				$idi = new EdificioIdiomasAtencion([
					'edificio_id' => $edificio->id,
					'idioma_id' => $idioma['id'],
				]);
				$idi->save();
			}

			DB::commit();

			$this->edificios = Edificio::all();

			$this->emit('SUBMIT_SUCCESS', '');

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'SUCCESS',
				'message' => 'Edificio creado'
			]);
		} catch (\Throwable $th) {

			DB::rollBack();

			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al registrar el edificio'
			]);
		}
	}

    public function render()
    {
        return view('livewire.edificios');
    }
}
