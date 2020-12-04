<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionSolicitudEdificiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion_solicitud_edificios', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('user_id');
			$table->bigInteger('edificio_id');
			$table->bigInteger('solicitud_id');
			$table->string('body');
			$table->tinyInteger('type');
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
        Schema::dropIfExists('notificacion_solicitud_edificios');
    }
}
