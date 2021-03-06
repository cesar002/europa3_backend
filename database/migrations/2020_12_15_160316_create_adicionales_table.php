<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdicionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adicionales', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('edificio_id');
			$table->bigInteger('unidad_id');
			$table->string('nombre');
			$table->text('descripcion')->nullable();
			$table->integer('unidad_base')->default(1);
			$table->integer('cantidad_maxima');
			$table->double('precio', 10, 4);
			$table->boolean('disponible')->default(true);
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
        Schema::dropIfExists('adicionales');
    }
}
