<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipio_id')->references('id')->on('municipios');
            $table->string('clave', 4);
            $table->string('nombre', 100);
            $table->string('latitud', 15);
            $table->string('longitud', 15);
            $table->string('altitud', 15);
            $table->string('carta', 19);
            $table->string('ambito', 1);
            $table->integer('poblacion');
            $table->integer('masculino');
            $table->integer('femenino');
            $table->integer('viviendas');
            $table->decimal('lat',10, 7);
            $table->decimal('lng', 10, 7);
            $table->boolean('activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}
