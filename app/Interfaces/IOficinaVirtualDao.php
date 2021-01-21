<?php

namespace App\Interfaces;

interface IOficinaVirtualDao{

	public function getAll();

	public function getByEdificioId($edificioId);

	public function getById($id);

}
