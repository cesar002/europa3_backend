<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudSalaJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('solicitud_id')->references('id')->on('solicitud_reservacion');
			$table->foreignId('sala_id')->references('id')->on('sala_juntas');
			$table->foreignId('metodo_pago_id')->references('id')->on('cat_metodos_pago');
			$table->date('fecha_reservacion');
			$table->time('hora_inicio');
			$table->time('hora_fin');
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
        Schema::dropIfExists('solicitud_sala_juntas');
    }
}
