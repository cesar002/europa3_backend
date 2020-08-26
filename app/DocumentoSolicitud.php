<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoSolicitud extends Model
{
    protected $table = 'documentos_solicitud';

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
