<?php

namespace App\Interfaces;

interface ISolicitudOficinaDao{

	public function getAll();

	public function getById($id);

	public function getByUserId($userId);

	public function getByOficinaId($oficinaId);

}
