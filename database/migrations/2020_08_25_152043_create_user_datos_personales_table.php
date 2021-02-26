<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDatosPersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_datos_personales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->references('id')->on('users')->onDelete('cascade');
			$table->foreignId('nacionalidad_id')->references('id')->on('cat_nacionalidades')->onDelete('cascade');
			$table->foreignId('tipo_identificacion_id')->references('id')->on('cat_tipos_identificacion');
            $table->string('nombre');
            $table->string('ape_p');
			$table->string('ape_m');
			$table->string('tipo_identificacion_otro')->nullable();
			$table->string('numero_identificacion');
            $table->string('RFC');
            $table->string('CURP');
            $table->date('fecha_nacimiento');
            $table->string('telefono');
            $table->string('celular');
            $table->string('domicilio');
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
        Schema::dropIfExists('user_datos_personales');
    }
}
