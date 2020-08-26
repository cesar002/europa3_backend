<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatSoporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_soporte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edificio_id')->references('id')->on('edificios');
			$table->integer('usertable_id')->unsigned();
			$table->string('usertable_type');
            $table->text('mensaje')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
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
        Schema::dropIfExists('chat_soporte');
    }
}
