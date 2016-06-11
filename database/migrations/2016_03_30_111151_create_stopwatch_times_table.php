<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStopwatchTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stopwatch_times', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('stopwatch_id')->unsigned();

            $table->integer('time');
            $table->bigInteger('created')->nullable();
            $table->boolean('is_paused')->default(0);

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
        Schema::drop('stopwatch_times');
    }
}
