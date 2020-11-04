<?php

namespace App\Repositories;

use App\CatFolio;
use Illuminate\Support\Facades\Log;

class FoliosRepository{

	public static function getCurrentFolio(string $typeFolio){
		try {
			if(empty($typeFolio))
				throw new \Exception('Tipo de folio no agregado');

			$numberFolio = CatFolio::where('folio', $typeFolio)->firstOrFail();
			$folio = self::formatterFolio($typeFolio, $numberFolio->consecutivo);

			return $folio;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return null;
		}
	}

	public static function getNextTempFolio(string $typeFolio){
		try {
			if(empty($typeFolio))
				throw new \Exception('Tipo de folio no agregado');

			$numberFolio = CatFolio::where('folio', $typeFolio)->firstOrFail();
			$folio = self::formatterFolio($typeFolio, $numberFolio->consecutivo + 1);

			return $folio;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return null;
		}
	}

	public static function generateNextFolio(string $typeFolio): void{
		$folio = CatFolio::where('folio', $typeFolio)->firstOrFail();
		$numberFolio = $folio->consecutivo + 1;

		$folio->consecutivo = $numberFolio;

		$folio->save();
	}

	private static function formatterFolio(string $typeFolio, $rawFolio){
		$size = 6;
		$rawFolioSize = strlen(strval($rawFolio));

		$diff = $size - $rawFolioSize;
		$ceros = "";

		for ($i=0; $i < $diff; $i++) {
			$ceros += "0";
		}

		return $typeFolio.$ceros;
	}

}
