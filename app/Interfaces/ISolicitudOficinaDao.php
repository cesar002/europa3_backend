<?php

namespace App\Interfaces;

interface ISolicitudOficinaDao{

	public function getAll();

	public function getByUserId($userId);

	public function getAllByEdificioId($edificioId);

	public function getToUserBySolicitudId($id);

	public function getById($id);

	public function getSolicitudRawById($id);

	public function getUserHistory($userId);

}
