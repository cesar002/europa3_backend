<?php

namespace App\Interfaces;

interface ISalaJuntasDao{

	public function getAllSalaJuntas();

	public function getSalaJuntaById($id);

	public function getSalaJuntasByEdificioId($edificioId);

}
