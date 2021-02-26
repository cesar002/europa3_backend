<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdicionalComprado extends Model
{
	protected $table = 'adicionales_comprados';

	protected $fillable = [
		'compra_id', 'adicional_id', 'cantidad', 'usado',
	];

	protected $hidden = [
		'created_at', 'updated_at',
	];

	public function adicionales(){
		return $this->belongsTo(\App\Adicional::class, 'adicional_id');
	}

	public function adicionalSolicitud(){
		return $this->belongsTo(\App\AdicionalCompraSolicitud::class, 'compra_id');
	}

}
