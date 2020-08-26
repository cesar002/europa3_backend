<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaDocumento extends Model
{
	protected $table = 'lista_documentos';

	public function documentosSolicitud(){
		return $this->hasMany(\App\DocumentoSolicitud::class, 'tipo_documento_id');
	}
}
