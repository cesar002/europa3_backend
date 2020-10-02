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
		DB::raw('INSERT INTO cat_tiempo_renta(tiempo, created_at, updated_at) VALUES ("Mensual", NOW(), NOW();');
		DB::raw('INSERT INTO cat_tiempo_renta(tiempo, created_at, updated_at) VALUES ("Horas", NOW(), NOW();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
