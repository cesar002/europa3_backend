<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobiliariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobiliarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_id')->references('id')->on('tipos_mobiliario');
            $table->foreignId('edificio_id')->references('id')->on('edificios')->onDelete('cascade');
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->longText('descripcion_bien');
            $table->longText('observaciones');
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('mobiliarios');
    }
}
