<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertEstadoDocumentoInCatEstadoDocumentoSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::insert('INSERT INTO cat_estado_documento_solicitud(estado) VALUES(?)', ['Subido']);
		DB::insert('INSERT INTO cat_estado_documento_solicitud(estado) VALUES(?)', ['Verificado']);
		DB::insert('INSERT INTO cat_estado_documento_solicitud(estado) VALUES(?)', ['Rechazado']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
