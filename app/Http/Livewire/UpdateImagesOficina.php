<?php

namespace App\Http\Livewire;

use App\Oficina;
use App\OficinaImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateImagesOficina extends Component
{

	use WithFileUploads;

	public $oficina, $images = [];

	public function submit()
	{
		$this->validate([
			'images' => 'required',
			'images.*' => 'required|image|max:10400',
		], [], [
			'images' => 'imagenes',
			'images.*' => 'imagen',
		]);

		try {
			DB::beginTransaction();
			$path = $this->oficina->getImagesPath();

			foreach ($this->images as $image) {
				$imagen = $image->store($path);
				OficinaImage::create([
					'oficina_id' => $this->oficina->id,
					'image' => basename($imagen),
				]);
			}

			DB::commit();
			$this->oficina = Oficina::with('imagenes', 'pathImages', 'pathImages.pathMaster')->findOrFail($this->oficina->id);
		} catch (\Throwable $th) {
			DB::rollBack();
			Log::error($th->getMessage());

			session()->flash('CALL_BACK_MESSAGE', [
				'status' => 'ERROR',
				'message' => 'Ocurrió un error al subir las imagenes'
			]);
		}
	}

	public function deleteImage(OficinaImage $imagen)
	{
		try {
			$path = $this->oficina->getImagesPath();

			Storage::delete("$path/{$imagen->image}");
			$imagen->delete();

			$this->oficina = Oficina::with('imagenes', 'pathImages', 'pathImages.pathMaster')->findOrFail($this->oficina->id);
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
        return view('livewire.update-images-oficina');
    }
}
