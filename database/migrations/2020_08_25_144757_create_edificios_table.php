<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdificiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edificios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('localidad')->references('id')->on('localidades');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono_1');
            $table->string('telefono_2')->nullable();
            $table->string('telefono_recepcion');
            $table->double('lat', 10, 7);
            $table->double('lon', 10, 7);
            $table->time('hora_apertura');
            $table->time('hora_cierre');
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
        Schema::dropIfExists('edificios');
    }
}
