<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaJuntasImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sala_juntas_imagenes', function (Blueprint $table) {
			$table->id();
			$table->foreignId('sala_juntas_id')->references('id')->on('sala_juntas')->onDelete('cascade');
			$table->string('image')->nullable(false);
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
        Schema::dropIfExists('sala_juntas_imagenes');
    }
}
