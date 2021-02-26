<?php

namespace App\Http\Controllers;

use App\Oficina;
use App\OficinaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OficinaImageController extends Controller{

	public function show($id){
		try {
			$data = Oficina::with('pathImages', 'pathImages.pathMaster', 'imagenes')->findOrFail($id);
			$pathImage = "{$data->pathImages->pathMaster->path}/{$data->pathImages->path}";
			$images = $data->imagenes->map(function($image) use($pathImage){
				return[
					'id' => $image->id,
					'url' => asset(Storage::url("$pathImage/{$image->image}")),
				];
			});

			return response($images);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}

	public function update(Request $request, $id){
		try {

			$pathImg = (Oficina::with('pathImages', 'pathImages.pathMaster')->findOrFail($id))->pathImages;
			$deleteImages = $request->images_delete;
			$newImages = $request->new_images;
			$fileNames = [];

			DB::beginTransaction();

			if(!is_null($deleteImages)){
				foreach ($deleteImages as $deleteImage) {
					$image = OficinaImage::findOrFail($deleteImage);
					array_push($fileNames, $image->image);
					$image->delete();
				}
			}

			if(!is_null($newImages)){
				foreach($newImages as $newImage){
					$image = Storage::disk('public')->put("{$pathImg->pathMaster->path}/{$pathImg->path}", $newImage);
					$newImageM = new OficinaImage([
						'oficina_id' => $id,
						'image' => basename($image),
					]);
					$newImageM->save();
				}
			}

			DB::commit();

			foreach($fileNames as $name){
				Storage::disk('public')->delete("{$pathImg->pathMaster->path}/{$pathImg->path}/$name");
			}

			return response([
				'message' => 'Imagenes guardadas con éxito'
			], 200);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());

			return response([
				'error' => 'No se pudieron guardar las imagenes'
			], 500);
		}
	}

}
