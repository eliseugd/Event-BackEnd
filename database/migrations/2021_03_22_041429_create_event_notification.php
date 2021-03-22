<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_notification', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('id_user');
            $table->smallInteger('id_event');
            $table->string('title');
            $table->string('description');
            $table->string('viewer');

            // $table->foreign('id_user')
            // ->references('id')
            // ->on('user');

            // $table->foreign('id_event')
            // ->references('id')
            // ->on('event');

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
        Schema::dropIfExists('event_notification');
    }
}
