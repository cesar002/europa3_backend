<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatEstadoDocumentoSolicitud extends Model
{
	protected $table = 'cat_estado_documento_solicitud';


	public function documentos(){
		return $this->hasMany(\App\DocumentoSolicitud::class, 'estado_id');
	}

}
