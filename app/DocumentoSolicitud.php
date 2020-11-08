<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoSolicitud extends Model
{
	protected $table = 'documentacion_solicitud';

	protected $fillable = [
		'solicitud_id', 'tipo_documento_id', 'path_id',
		'nombre_archivo','tipo_archivo'
	];

	protected $casts = [
		'validado' => 'boolean',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

    public function solicitud(){
        return $this->belongsTo(\App\SolicitudReservacion::class, 'solicitud_id');
    }

    public function tipoDocumento(){
        return $this->belongsTo(\App\ListaDocumento::class, 'tipo_documento_id');
    }

    public function pathDocumento(){
        return $this->belongsTo(\App\PathFile::class, 'path_id');
    }
}
