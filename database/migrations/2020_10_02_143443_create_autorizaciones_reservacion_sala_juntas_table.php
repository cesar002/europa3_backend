<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorizacionesReservacionSalaJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizaciones_reservaciones_sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('reservacion_id')->references('id')->on('solicitud_reservacion_sala_juntas');
			$table->boolean('autorizado');
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
        Schema::dropIfExists('autorizaciones_reservaciones_sala_juntas');
    }
}
