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
			INSERT INTO lista_documentos(documento, tipo_documento, obligatorio, created_at, updated_at) VALUES
			('INE/IFE (parte frontal)', 1, 1, NOW(), NOW()),
			('INE/IFE (parte trasera)', 1, 1, NOW(), NOW()),
			('PASAPORTE', 1, 0, NOW(), NOW()),
			('RFC', 2, 1, NOW(), NOW()),
			('CURP',2, 1, NOW(), NOW()),
			('Acta constitutiva', 2, 1, NOW(), NOW()),
			('Poder', 2, 1, NOW(), NOW()),
			('Constancia de cumplimiento fiscal', 2, 1, NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
