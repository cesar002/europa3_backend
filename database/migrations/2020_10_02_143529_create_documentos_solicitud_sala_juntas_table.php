<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosSolicitudSalaJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_solicitud_sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('solicitud_sala_juntas_id')->references('id')->on('solicitud_reservacion_sala_juntas');
			$table->foreignId('tipo_documento_id')->references('id')->on('cat_metodos_pago');
			$table->foreignId('path_id')->references('id')->on('path_files');
			$table->string('nombre_archivo');
			$table->boolean('validado')->default(false);
			$table->boolean('llevar_fisico')->default(false);
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
        Schema::dropIfExists('documentos_solicitud_sala_juntas');
    }
}
