<?php

namespace App\Interfaces;

interface ITipoPagoDao{

	public function getAll();

	public function getById($id);

}
