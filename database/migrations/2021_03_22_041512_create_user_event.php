<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_event', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('id_user');
            $table->smallInteger('id_event');
            $table->string('participation_situation');

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
        Schema::dropIfExists('user_event');
    }
}
