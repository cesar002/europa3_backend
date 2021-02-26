<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdificioIdiomasAtencionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edificio_idiomas_atencion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificio_id')->references('id')->on('edificios')->onDelete('cascade');
            $table->foreignId('idioma_id')->references('id')->on('cat_idiomas_atencion')->onDelete('cascade');
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
        Schema::dropIfExists('edificio_idiomas_atencion');
    }
}
