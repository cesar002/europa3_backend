<?php

namespace App\Http\Controllers;

use App\SalaImage;
use App\SalaJuntas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SalaJuntasImagesController extends Controller {

	public function show($id){
		try {
			$sala = SalaJuntas::with('imagenes', 'pathImages', 'pathImages.pathMaster')->findOrFail($id);
			$path = "{$sala->pathImages->pathMaster->path}/{$sala->pathImages->path}";
			$imagenes = $sala->imagenes->map(function($img) use($path){
				return [
					'id' => $img->id,
					'url' => asset(Storage::url("$path/{$img->image}")),
				];
			});

			return response($imagenes);
		} catch (\Throwable $th) {
			return response([]);
		}
	}

	public function update(Request $request, $id){
		try {
			DB::beginTransaction();

			$pathImg = (SalaJuntas::with('pathImages', 'pathImages.pathMaster')->findOrFail($id))->pathImages;
			$deleteImages = $request->images_delete;
			$newImages = $request->new_images;
			$fileNames = [];

			if(!is_null($deleteImages)){
				foreach ($deleteImages as $deleteImage) {
					$image = SalaImage::findOrFail($deleteImage);
					array_push($fileNames, $image->image);
					$image->delete();
				}
			}

			if(!is_null($newImages)){
				foreach($newImages as $newImage){
					$image = Storage::disk('public')->put("{$pathImg->pathMaster->path}/{$pathImg->path}", $newImage);
					$newImageM = new SalaImage([
						'sala_juntas_id' => $id,
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
			Log::error($th->getMessage());

			DB::rollBack();

			return response([
				'error' => 'No se pudo actualizar las imagenes de la sala',
			], 500);
		}
	}

}
