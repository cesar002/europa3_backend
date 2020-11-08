<?php

namespace App\Http\Controllers;

use App\DocumentoSolicitud;
use App\PathFile;
use App\PathMaster;
use App\SolicitudReservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentosSolicitudController extends Controller
{

	public function userDocumentsBySolicitudId(Request $request, $solicitudId){

	}

	public function showDocumentsBySolicitudId($solicitudId){
		try {
			$solicitud = SolicitudReservacion::with('documentos', 'documentos.tipoDocumento')->findOrFail($solicitudId);

			return response($solicitudId);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response(json_encode([], JSON_FORCE_OBJECT));
		}
	}

	public function downloadDocumento($solicitudId, $id){
		try {
			$solicitud = SolicitudReservacion::findOrFail($solicitudId);
			$documento = $solicitud->documentos()->with('pathDocumento', 'pathDocumento.pathMaster')->findOrFail($id);

			$path = "{$documento->pathDocumento->pathMaster->path}\\{$documento->pathDocumento->path}\\{$documento->nombre_archivo}";

			return Storage::disk('local')->download($path);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error en la descarga'
			], 500);
		}
	}

	public function updateUploadDocumento(\App\Http\Requests\UploadDocumentoRequest $request, $id){
		try {
			DB::beginTransaction();

			$documentoModel = DocumentoSolicitud::with('pathDocumento', 'pathDocumento.pathMaster')->findOrFail($id);
			$path = "{$documentoModel->pathDocumento->pathMaster->path}\\{$documentoModel->pathDocumento->path}";

			$documento = Storage::disk('local')->put($path, $request->documento);
			Storage::disk('local')->delete("$path\\{$documentoModel->nombre_archivo}");

			$documentoModel->tipo_documento_id = $request->tipo_documento;
			$documentoModel->nombre_archivo = basename($documento);
			$documentoModel->tipo_archivo = pathinfo($documento, PATHINFO_EXTENSION);
			$documentoModel->save();

			DB::commit();

			return response([
				'message' => 'Documento actualizado con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			DB::rollBack();

			return response([
				'error' => 'Ocurrió un error al actualizar el documento',
			], 500);
		}
	}

	public function uploadDocumento(\App\Http\Requests\UploadDocumentoRequest $request, $solicitudId){
		try {
			DB::beginTransaction();

			$solicitud = SolicitudReservacion::findOrFail($solicitudId);
			$existDocument = $solicitud->documentos()->with('pathDocumento')->first();
			$pathMaster = PathMaster::findOrFail(1);

			$path = "";

			if(is_null($existDocument)){
				$pathDocumentos = new PathFile([
					'path_master_id' => $pathMaster->id,
					'nombre' => "Documentos - {$request->user()->email}",
					'path' => Str::random(rand(5, 25)),
				]);
				$pathDocumentos->save();

				$path = "{$pathMaster->path}/{$pathDocumentos->path}";
				Storage::disk('local')->makeDirectory($path);
			}else{
				$path = "{$pathMaster->path}/{$existDocument->pathDocumento->path}";
			}


			$documento = Storage::disk('local')->put($path, $request->documento);

			$documentoModel = new DocumentoSolicitud([
				'solicitud_id' => $solicitudId,
				'tipo_documento_id' => $request->tipo_documento,
				'path_id' => !empty($pathDocumentos) ? $pathDocumentos->id : $existDocument->pathDocumento->id,
				'nombre_archivo' => basename($documento),
				'tipo_archivo' =>  pathinfo($documento, PATHINFO_EXTENSION)
			]);

			$solicitud->subida_documentos = 1;
			$solicitud->save();

			$documentoModel->save();

			DB::commit();
			return response([
				'message' => 'Documento subido con éxito',
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			Log::error($th->getMessage());
			return response([
				'error' => 'No se pudo subir el documento'
			], 500);
		}
	}

}
