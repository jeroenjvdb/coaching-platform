<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('training_id')->unsigned();
            $table->integer('category_exercise_id')->unsigned();

            $table->integer('sets')->default(1);
            $table->integer('meters');
            $table->string('description');

            $table->integer('position')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exercises');
    }
}
