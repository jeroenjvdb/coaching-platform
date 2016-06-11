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
            $table->string('slug');

            /**
             * foreign keys
             */
            $table->integer('group_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->integer('swimrankings_id')->unsigned();
            /**
             * data
             */
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_man');
            $table->datetime('birthday');

            /**
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
