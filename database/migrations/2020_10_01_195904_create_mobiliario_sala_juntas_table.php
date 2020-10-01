<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobiliarioSalaJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobiliario_sala_juntas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('sala_juntas_id')->references('id')->on('sala_juntas')->onDelete('cascade');
			$table->foreignId('mobiliario_id')->references('id')->on('mobiliarios');
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
        Schema::dropIfExists('mobiliario_sala_juntas');
    }
}
