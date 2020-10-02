<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDatosMoralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_datos_morales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->references('id')->on('users')->onDelete('cascade');
            $table->string('nombre_empresa')->nullable();
            $table->string('nombre')->nullable();
            $table->string('ape_p')->nullable();
            $table->string('ape_m')->nullable();
            $table->string('escritura_publica')->nullable();
            $table->string('numero_notario')->nullable();
            $table->date('fecha_constitucion')->nullable();
            $table->string('giro_comercial')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('user_datos_morales');
    }
}
