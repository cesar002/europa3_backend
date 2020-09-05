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
            $table->longText('folio')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
			$table->foreignId('oficina_id')->references('id')->on('oficinas');
			$table->foreignId('metodo_pago_id')->references('id')->on('cat_metodos_pago');
			$table->foreignId('solicitud_id')->nullable()->references('id')->on('solicitud_reservacion');
            $table->smallInteger('plazo');
            $table->smallInteger('numero_ocupantes');
			$table->boolean('finalizado')->default(false);
			$table->boolean('revalidado')->default(false);
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
        Schema::dropIfExists('solicitud_reservacion');
    }
}
