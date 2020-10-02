<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosCompradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos_comprados', function (Blueprint $table) {
            $table->id();
            $table->longText('folio')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('oficina_id')->references('id')->on('oficinas')->onDelete('cascade');
            $table->foreignId('insumo_id')->references('id')->on('insumos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->double('importe', 10, 4);
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
        Schema::dropIfExists('insumos_comprados');
    }
}
