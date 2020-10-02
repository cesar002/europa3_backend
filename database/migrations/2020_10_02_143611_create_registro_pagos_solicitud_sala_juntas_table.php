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
        Schema::create('registro_pago_solicitud_sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('solicitud_sala_juntas_id');
			$table->foreign('solicitud_sala_juntas_id', 'pago_solicitud_FK')->references('id')->on('solicitud_reservacion_sala_juntas');
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
		Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('registro_pago_solicitud_sala_juntas');
    }
}
