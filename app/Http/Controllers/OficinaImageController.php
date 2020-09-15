<?php

namespace App\Http\Controllers;

use App\Oficina;
use App\OficinaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OficinaImageController extends Controller{

	public function update(\App\Http\Requests\OficinaImageRequest $request, $id){
		try {

			DB::beginTransaction();

			$pathImg = (Oficina::with('pathImages', 'pathImages.pathMaster')->findOrFail($id))->pathImages;
			$images = $request->images;

			$ids_images = collect($request->images_delete)->map(function($image){
				return $image->id;
			});

			OficinaImage::destroy($ids_images);



			foreach($images as $image){
				$nameImage = Storage::put("{$pathImg->pathMaster->path}/{$pathImg->path}", $image);

				$imageOficina = new OficinaImage([
					'oficina_id' => $id,
					'image' => basename($nameImage),
				]);

				$imageOficina->save();
			}

			DB::commit();

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
