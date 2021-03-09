<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertEstadosInCatEstadosSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['Iniciado']);
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['Autorizado']);
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['No Autorizado']);
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['Cancelado']);
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['Finalizado']);
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['Revalidado']);
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['Autorizado pagado']);
		DB::insert('INSERT INTO cat_estados_solicitud(nombre, created_at, updated_at) VALUES(?, NOW(), NOW())',
		['z']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
