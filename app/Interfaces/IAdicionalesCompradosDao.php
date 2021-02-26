<?php

namespace App\Interfaces;

interface IAdicionalesCompradosDao{

	public function getAll();

	public function getById($id);

	public function getBySolicitudId($solicitudId);

	public function getByUserId($userId);

}