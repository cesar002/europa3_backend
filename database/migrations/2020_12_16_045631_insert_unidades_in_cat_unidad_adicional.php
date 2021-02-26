<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertUnidadesInCatUnidadAdicional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		DB::insert('INSERT INTO cat_unidad_adicional(unidad, abreviacion, created_at, updated_at)
					VALUES (?, ?, NOW(), NOW())', ['Paquete', 'pqt']);
		DB::insert('INSERT INTO cat_unidad_adicional(unidad, abreviacion, created_at, updated_at)
					VALUES (?, ?, NOW(), NOW())', ['Unidad', 'ud']);
		DB::insert('INSERT INTO cat_unidad_adicional(unidad, abreviacion, created_at, updated_at)
					VALUES (?, ?, NOW(), NOW())', ['Pieza', 'pza']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
