<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushNotificationsSentToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notifications_sent_to_users', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('user_id');
			$table->string('title');
			$table->string('body');
			$table->json('data')->nullable();
            $table->timestamps();

			$table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_notifications_sent_to_users');
    }
}
