<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertTiposPagosInCatTiposPagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up(){
		DB::unprepared("
			INSERT INTO cat_metodos_pago(nombre, presencial, virtual, created_at, updated_at) VALUES
			('Pago en la aplicación', 0, 1, NOW(), NOW()),
			('Transferencia bancaria', 1, 0, NOW(), NOW()),
			('Pago presencial', 1, 0, NOW(), NOW());
		");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
