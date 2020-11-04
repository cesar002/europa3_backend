<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentacionSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentacion_solicitud', function (Blueprint $table) {
			$table->id();
			$table->foreignId('solicitud_id')->references('id')->on('solicitud_reservacion');
            $table->foreignId('tipo_documento_id')->references('id')->on('lista_documentos');
            $table->foreignId('path_id')->references('id')->on('path_files');
			$table->string('nombre_archivo');
			$table->string('tipo_archivo', 5);
			$table->boolean('validado')->default(false);
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
        Schema::dropIfExists('documentacion_solicitud');
    }
}
