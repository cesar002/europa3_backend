<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertCatIdentificacionesInCatTiposIdentificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		DB::unprepared("
			INSERT INTO cat_tipos_identificacion(nombre, created_at, updated_at) VALUES ('INE', NOW(), NOW()),
				('Pasaporte', NOW(), NOW()),
				('Cédula', NOW(), NOW()),
				('Licencia', NOW(), NOW()),
				('Otro', NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
