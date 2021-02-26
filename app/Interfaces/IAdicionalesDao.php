<?php

namespace App\Interfaces;

interface IAdicionalesDao {

	public function getById($id);

	public function getAll();

	public function getByEdificioId($edificioId);

}
