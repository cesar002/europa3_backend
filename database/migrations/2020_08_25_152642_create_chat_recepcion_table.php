<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRecepcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_recepcion', function (Blueprint $table) {
            $table->id();
			// $table->foreignId('user_id');
			$table->text('mensaje')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
			$table->bigInteger('chatable_id');
			$table->string('chatable_type');
			$table->bigInteger('solicitud_id');
			$table->bigInteger('edificio_id');
			$table->tinyInteger('sender_by');
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
        Schema::dropIfExists('chat_recepcion');
    }
}
