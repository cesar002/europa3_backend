<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDatosFiscalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_datos_fiscales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('estado_id')->references('id')->on('estados');
            $table->foreignId('municipio_id')->references('id')->on('municipios');
            $table->string('email');
            $table->string('razon_social');
            $table->string('RFC');
            $table->string('telefono');
            $table->string('calle');
            $table->string('numero_exterior')->nullable();
            $table->string('numero_interior')->nullable();
            $table->smallInteger('codigo_postal');
            $table->string('colonia');
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
        Schema::dropIfExists('user_datos_fiscales');
    }
}
