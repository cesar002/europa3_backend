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
			$table->foreignId('path_id')->references('id')->on('path_images');
			$table->string('nombre');
            $table->string('marca');
            $table->string('modelo')->nullable();
            $table->string('color');
            $table->longText('descripcion_bien')->nullable();
			$table->longText('observaciones')->nullable();
			$table->mediumInteger('cantidad');
			$table->mediumInteger('usado')->default(0);
			$table->boolean('activo')->default(true);
			$table->string('image');
			$table->softDeletes();
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
        Schema::dropIfExists('mobiliarios');
    }
}
