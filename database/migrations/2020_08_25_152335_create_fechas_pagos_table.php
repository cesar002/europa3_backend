<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechasPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechas_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->references('id')->on('solicitud_reservacion');
            $table->date('fecha_pago');
            $table->double('monto_pago', 10, 4);
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
        Schema::dropIfExists('fechas_pagos');
    }
}
