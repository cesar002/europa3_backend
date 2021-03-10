<?php

namespace App\Http\Controllers;

use App\DocumentoSolicitud;
use App\Http\Requests\UploadDocumentoRequest;
use App\ListaDocumento;
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

	public function getListDocuments(){
		try {
			$lista = ListaDocumento::all();

			return response($lista);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([]);
		}
	}

	public function allowUpdateDocument($id){
		try {

			$documento = DocumentoSolicitud::findOrFail($id);
			$documento->actualizable = true;
			$documento->save();

			return response([
				'message' => 'Cambios realizados correctamente'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());

			return response([
				'error' => 'Ocurrió un error al permitir la actualización'
			], 500);
		}
	}

	public function validateDocument($id){
		try {
			$documento = DocumentoSolicitud::findOrFail($id);
			$documento->estado_id = 2;
			$documento->save();

			return response([
				'message' => 'El documento se validó con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error en la validación del documento'
			], 500);
		}
	}

	public function invalidateDocument($id){
		try {

			$documento = DocumentoSolicitud::findOrFail($id);
			$documento->estado_id = 3;
			$documento->save();

			return response([
				'message' => 'El documento se invalidó con éxito'
			]);
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al invalidar el documento'
			], 500);
		}
	}

	public function downloadDocument($id){
		try {

			$documento = DocumentoSolicitud::with('pathDocumento', 'pathDocumento.pathMaster')->findOrFail($id);
			$path = "{$documento->pathDocumento->pathMaster->path}/{$documento->pathDocumento->path}/{$documento->nombre_archivo}";

			return Storage::download($path);
			// return $path;
		} catch (\Throwable $th) {
			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al gestionar la descarga'
			], 500);
		}
	}

	public function uploadDocument(UploadDocumentoRequest $request, $solicitudId){
		try {
			DB::beginTransaction();

			$solicitud = SolicitudReservacion::findOrFail($solicitudId);
			$document = $solicitud->documentos()->with('pathDocumento')->first();
			$pathMaster = PathMaster::findOrFail(1);
			$path = "";

			if(is_null($document)){
				$pathDocumentos = new PathFile([
					'path_master_id' => $pathMaster->id,
					'nombre' => "Documentos - {$request->user()->email}",
					'path' => Str::random(rand(5, 25)),
				]);

				$pathDocumentos->save();

				$path = "{$pathMaster->path}/{$pathDocumentos->path}";
				Storage::makeDirectory($path);
			}else{
				$path = "{$pathMaster->path}/{$document->pathDocumento->path}";
			}

			$uploadedDocument = Storage::put($path, $request->documento);

			$documentoModel = new DocumentoSolicitud([
				'solicitud_id' => $solicitudId,
				'tipo_documento_id' => $request->tipo_documento,
				'path_id' => !empty($pathDocumentos) ? $pathDocumentos->id : $document->pathDocumento->id,
				'nombre_archivo' => basename($uploadedDocument),
				'tipo_archivo' =>  pathinfo($uploadedDocument, PATHINFO_EXTENSION)
			]);

			$documentoModel->save();

			DB::commit();
			return response([
				'message' => 'Documento subido con éxito',
			]);
		} catch (\Throwable $th) {
			DB::rollBack();

			Log::error($th->getMessage());
			return response([
				'error' => 'Ocurrió un error al subir el documento'
			], 500);
		}
	}

	public function updateDocumento(UploadDocumentoRequest $request, $id){
		try {
			DB::beginTransaction();

			$documentoModel = DocumentoSolicitud::with('pathDocumento', 'pathDocumento.pathMaster')->findOrFail($id);
			$path = "{$documentoModel->pathDocumento->pathMaster->path}\\{$documentoModel->pathDocumento->path}";

			$documento = Storage::put($path, $request->documento);
			Storage::delete("$path\\{$documentoModel->nombre_archivo}");

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

}
