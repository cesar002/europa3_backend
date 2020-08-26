<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PathFile extends Model
{
	protected $table = 'path_files';

	public function pathMaster(){
		return $this->belongsTo(\App\PathMaster::class, 'path_master_id');
	}

	public function documentosSolicitud(){
		return $this->hasMany(\App\DocumentoSolicitud::class, 'path_id');
	}

}
