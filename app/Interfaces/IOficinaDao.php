<?php

namespace App\Interfaces;

interface IOficinaDao{

	public function getAllOficinas();

	public function getOficinaById($id);

	public function getOficinasByEdificioId($edificioId);

	public function getOficinasByMunicipioId($municipioId);

	public function getOficinasByEstadoId($estadoId);

}
