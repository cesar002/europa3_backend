<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertListaDocumentosInListaDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		DB::unprepared("
			INSERT INTO lista_documentos(documento, obligatorio, created_at, updated_at) VALUES
			('Identificacion oficial (INE, PASAPORTE)', 1, NOW(), NOW()),
			('RFC', 1, NOW(), NOW()),
			('CURP', 1, NOW(), NOW()),
			('Acta constitutiva', 1, NOW(), NOW()),
			('Poder', 1, NOW(), NOW()),
			('Constancia de cumplimiento fiscal', 1, NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
