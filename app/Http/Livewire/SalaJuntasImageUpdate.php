<?php

namespace App\Http\Livewire;

use App\SalaJuntas;
use Livewire\Component;
use App\SalaJuntasImagenes;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SalaJuntasImageUpdate extends Component
{

	use WithFileUploads;

	public $sala, $images=[];

	public function submit()
	{
		$this->validate([
			'images.*' => 'required|image|max:10400',
		], [], [
			'images.*' => 'imagen',
		]);

		try{
			DB::beginTransaction();

			$path = $this->sala->getImagesPath();
			foreach ($this->images as $image) {
				$imagen = $image->store($path);
				SalaJuntasImagenes::create([
					'sala_juntas_id' => $this->sala->id,
					'image' => basename($imagen),
				]);
			}

			$this->sala = SalaJuntas::with('imagenes', 'pathImages', 'pathImages.pathMaster')->findOrFail($this->sala->id);

			$this->reset('images');

			DB::commit();
		}catch(\Throwable $th){
			DB::rollback();
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al subir las imagenes'
			]);
		}
	}

	public function deleteImage(SalaJuntasImagenes $imagen)
	{
		try {
			$path = $this->sala->getImagesPath();

			Storage::delete("$path/{$imagen->image}");
			$imagen->delete();

			$this->sala = SalaJuntas::with('imagenes', 'pathImages', 'pathImages.pathMaster')->findOrFail($this->sala->id);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al eliminar la imagen'
			]);
		}
	}

    public function render()
    {
        return view('livewire.sala-juntas-image-update');
    }
}
