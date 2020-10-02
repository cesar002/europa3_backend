<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroPagosSolicitudSalaJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_pagos_solicitud_sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('solicitud_sala_juntas_id')->references('id')->on('solicitud_reservacion_sala_juntas');
			$table->foreignId('user_id')->references('id')->on('users');
			$table->string('folio');
			$table->dateTime('fecha_pago');
			$table->double('monto_pago', 10, 4);
			$table->boolean('verificado')->default(false);
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
        Schema::dropIfExists('registro_pagos_solicitud_sala_juntas');
    }
}
