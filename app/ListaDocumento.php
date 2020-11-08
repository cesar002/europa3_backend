<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaDocumento extends Model
{
	protected $table = 'lista_documentos';

	protected $casts = [
		'obligatorio' => 'boolean',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

	public function documentosSolicitud(){
		return $this->hasMany(\App\DocumentoSolicitud::class, 'tipo_documento_id');
	}
}
