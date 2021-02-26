<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PathFile extends Model
{
	protected $table = 'path_files';

	protected $fillable = [
		'path_master_id', 'nombre', 'path'
	];

	public function pathMaster(){
		return $this->belongsTo(\App\PathMaster::class, 'path_master_id');
	}

	public function documentosSolicitud(){
		return $this->hasMany(\App\DocumentoSolicitud::class, 'path_id');
	}

}
