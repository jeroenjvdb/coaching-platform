<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->text('name');
            $table->text('description');

            $table->text('url_picture_start')->nullable();
            $table->text('url_picture_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('g_exercises');
    }
}
