<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwimmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swimmers', function(Blueprint $table)
        {
            $table->increments('id');

            /*
            *   foreign keys
            */
            $table->integer('swimrankings_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('profile_id')->unsigned();

            /*
            *   data
            */
            $table->string('name');
            $table->boolean('is_man');
            $table->datetime('date_of_birth');

            /*
            * timestamps
            */
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('swimmers');
    }
}
