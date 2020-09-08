<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertTipoOficinasInCatTiposOficina extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		DB::unprepared("
			INSERT INTO cat_tipos_oficina(tipo, created_at, updated_at) VALUES
			('Oficina privada', NOW(), NOW()),
			('Sala de juntas', NOW(), NOW()),
			('Oficina virtual', NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
