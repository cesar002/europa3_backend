<?php

namespace App\Interfaces;

interface IChatRecepcionDao{

	public function getMessageById($id);

	public function getMessagesBySolicitudId($id);

}
