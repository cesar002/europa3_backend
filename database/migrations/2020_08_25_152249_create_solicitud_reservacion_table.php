<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudReservacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_reservacion', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
			$table->foreignId('solicitud_id')->nullable(true)->references('id')->on('solicitud_reservacion');
			$table->foreignId('estado_id')->references('id')->on('cat_estados_solicitud');
			$table->foreignId('metodo_pago_id')->nullable(true)->references('id')->on('cat_metodos_pago');
			$table->integer('tipo_oficina')->unsigned();
			$table->date('fecha_reservacion');
			$table->smallInteger('meses_renta')->nullable(true);
			$table->smallInteger('numero_integrantes')->nullable(true);
			$table->time('hora_inicio')->nullable(true);
			$table->time('hora_fin')->nullable(true);
			$table->boolean('terminos_condiciones')->default(true);
			$table->integer('solicitudable_id');
			$table->string('solicitudable_type');
			$table->softDeletes();
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
        Schema::dropIfExists('solicitud_reservacion');
    }
}
