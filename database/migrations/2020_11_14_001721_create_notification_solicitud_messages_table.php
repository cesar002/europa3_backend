<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSolicitudMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_solicitud_messages', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('user_id');
			$table->bigInteger('edificio_id');
			$table->bigInteger('solicitud_id');
			$table->integer('type');
			$table->integer('status_solicitud');
			$table->string('body');
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
        Schema::dropIfExists('notification_solicitud_messages');
    }
}
