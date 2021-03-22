<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->date('date');
            $table->smallInteger('id_user_creator');
            $table->smallInteger('id_category');
            $table->string('status');

            // $table->foreign('id_user_creator')
            // ->references('id')
            // ->on('user');

            // $table->foreign('id_category')
            // ->references('id')
            // ->on('category_event');

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
        Schema::dropIfExists('event');
    }
}
