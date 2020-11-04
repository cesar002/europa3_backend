<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudReservacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_reservacion', function (Blueprint $table) {
            $table->id();
            $table->longText('folio')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
			$table->foreignId('solicitud_id')->nullable()->references('id')->on('solicitud_reservacion');
			$table->boolean('iniciado')->default(true);
			$table->boolean('subida_documentos')->default(false);
			$table->boolean('en_revision')->default(false);
			$table->boolean('autorizado')->default(false);
			$table->boolean('finalizado')->default(false);
			$table->boolean('revalidado')->default(false);
			$table->boolean('terminos_condiciones')->default(true);
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
        Schema::dropIfExists('solicitud_reservacion');
    }
}
