<?php

namespace App\Interfaces;

interface IMobiliarioDao{

	public function getAll();

	public function getAllByEdificioId($edificioId);

	public function getById($id);

}
