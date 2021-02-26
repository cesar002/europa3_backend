<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PathMaster extends Model
{
	protected $table = 'paths_master';


	public function pathsFiles(){
		return $this->hasMany(\App\PathFile::class, 'path_master_id');
	}

	public function pathsImages(){
		return $this->hasMany(\App\PathImage::class, 'path_master_id');
	}

}
