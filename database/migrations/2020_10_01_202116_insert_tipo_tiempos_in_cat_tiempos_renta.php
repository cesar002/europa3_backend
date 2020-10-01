<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertTipoTiemposInCatTiemposRenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		DB::insert('INSERT cat_tiempo_renta(tiempo, created_at, updated_at) VALUES (?, NOW(), NOW()', ['Mensual']);
		DB::insert('INSERT cat_tiempo_renta(tiempo, created_at, updated_at) VALUES (?, NOW(), NOW()', ['Horas']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
