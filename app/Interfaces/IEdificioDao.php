<?php

namespace App\Interfaces;

interface IEdificioDao{

	public function getEdificioById(int $id);

	public function getAllEdificios();

	public function getAllEdificiosByEstadoId(int $estadoId);

	public function getAllEdificiosByMunicipioId(int $municipioId);

	public function getAllEdificiosByEstadoIdAndMunicipioId(int $estadoId, int $municipioId);

}
