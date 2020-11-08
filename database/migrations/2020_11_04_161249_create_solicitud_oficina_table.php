<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudOficinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_oficina', function (Blueprint $table) {
			$table->id();
			$table->foreignId('solicitud_id')->references('id')->on('solicitud_reservacion');
			$table->foreignId('oficina_id')->references('id')->on('oficinas');
			$table->foreignId('metodo_pago_id')->references('id')->on('cat_metodos_pago')->nullable();
			$table->date('fecha_reservacion');
			$table->smallInteger('meses_renta');
			$table->smallInteger('numero_integrantes');
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
        Schema::dropIfExists('solicitud_oficina');
    }
}
