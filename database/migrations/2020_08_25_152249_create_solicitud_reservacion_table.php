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
            $table->date('fecha_reservacion');
            $table->smallInteger('plazo');
            $table->smallInteger('numero_ocupantes');
            $table->boolean('aprobado')->nullable();
            $table->dateTime('fecha_aprobacion')->nullable();
            $table->boolean('finalizado')->nullable();
            $table->boolean('terminos_condiciones');
            $table->boolean('revalidado')->default(false);
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
