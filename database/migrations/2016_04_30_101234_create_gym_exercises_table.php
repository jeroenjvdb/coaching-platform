<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gym_exercises', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('gym_id')->unsigned();
            $table->integer('g_exercise_id')->unsigned();

            $table->integer('sets');
            $table->integer('reps');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gym_exercises');
    }
}
