<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudReservacionSalaJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_reservacion_sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->string('folio')->unique();
			$table->foreignId('user_id')->references('id')->on('users');
			$table->foreignId('sala_juntas_id')->references('id')->on('sala_juntas');
			$table->foreignId('metodo_pago_id')->references('id')->on('cat_metodos_pago');
			$table->dateTime('fecha_reservacion')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->time('hora_inicio');
			$table->time('hora_fin');
			$table->boolean('finalizado')->default(false);
			$table->boolean('terminos_condiciones');
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
        Schema::dropIfExists('solicitud_reservacion_sala_juntas');
    }
}
