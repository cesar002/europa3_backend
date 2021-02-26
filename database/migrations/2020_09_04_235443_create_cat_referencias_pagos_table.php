<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatReferenciasPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_referencias_pagos', function (Blueprint $table) {
			$table->id();
			$table->foreignId('metodo_pago_id')->references('id')->on('cat_metodos_pago');
			$table->string('referencia');
			$table->string('entidad_bancaria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cat_referencias_pagos');
    }
}
