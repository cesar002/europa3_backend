<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertTiposMobiliarioInTipoMobiliario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		DB::unprepared("
		INSERT INTO tipos_mobiliario(tipo, created_at, updated_at) VALUES
			('Sillas ejecutivas', NOW(), NOW()),
			('Sillas operativas', NOW(), NOW()),
			('Multiusos', NOW(), NOW()),
			('Sofás', NOW(), NOW()),
			('Escritorios', NOW(), NOW()),
			('Mesas', NOW(), NOW()),
			('Sistemas modulares', NOW(), NOW()),
			('Archiveros', NOW(), NOW()),
			('Gabinetes', NOW(), NOW()),
			('Lockers', NOW(), NOW()),
			('Estantes', NOW(), NOW()),
			('Estantes móviles', NOW(), NOW()),
			('Equipo de computo', NOW(), NOW()),
			('Equipo teléfonico', NOW(), NOW()),
			('Repisas y alacenas', NOW(), NOW()),
			('Aires acondicionados', NOW(), NOW()),
			('Equipo de cocina', NOW(), NOW()),
			('Estantes', NOW(), NOW()),
			('Botes de basura', NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
