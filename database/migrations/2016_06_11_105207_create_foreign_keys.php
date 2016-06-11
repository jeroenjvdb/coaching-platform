<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    public function up()
    {
        Schema::table('swimmers', function(Blueprint $table) {
//            $table->foreign('user_id')->references('id')->on('users')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('coaches', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('coach_group', function(Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('coach_id')->references('id')->on('coaches')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('trainings', function(Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('category_exercises', function(Blueprint $table) {
            $table->foreign('training_id')->references('id')->on('trainings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('exercises', function(Blueprint $table) {
            $table->foreign('category_exercise_id')->references('id')->on('category_exercises')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            });

            Schema::table('presences', function(Blueprint $table) {
                $table->foreign('training_id')->references('id')->on('trainings')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('swimmer_id')->references('id')->on('swimmers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('distances', function(Blueprint $table) {
                $table->foreign('stroke_id')->references('id')->on('strokes')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('stopwatches', function(Blueprint $table) {
                $table->foreign('distance_id')->references('id')->on('distances')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('swimmer_id')->references('id')->on('swimmers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
    //            $table->foreign('user_id')->references('id')->on('users')
    //                ->onDelete('cascade')
    //                ->onUpdate('cascade');
            });

            Schema::table('stopwatch_times', function(Blueprint $table) {
                $table->foreign('stopwatch_id')->references('id')->on('stopwatches')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('gyms', function(Blueprint $table) {
                $table->foreign('group_id')->references('id')->on('groups')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('gym_exercises', function(Blueprint $table) {
                $table->foreign('gym_id')->references('id')->on('gyms')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('g_exercise_id')->references('id')->on('g_exercises')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('gym_exercises_categories', function(Blueprint $table) {
                $table->foreign('exercise_id')->references('id')->on('gym_exercises')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('category_id')->references('id')->on('gym_categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('heart_rates', function(Blueprint $table) {
                $table->foreign('swimmer_id')->references('id')->on('swimmers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('weights', function(Blueprint $table) {
                $table->foreign('swimmer_id')->references('id')->on('swimmers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

    }

    public function down()
    {
        Schema::table('swimmers', function(Blueprint $table) {
//            $table->dropForeign('swimmers_user_id_foreign');
            $table->dropForeign('swimmers_group_id_foreign');
        });

        Schema::table('coaches', function(Blueprint $table) {
            $table->dropForeign('coaches_user_id_foreign');
        });

        Schema::table('coach_group', function(Blueprint $table) {
            $table->dropForeign('coach_group_group_id_foreign');
            $table->dropForeign('coach_group_coach_id_foreign');
        });

        Schema::table('trainings', function(Blueprint $table) {
            $table->dropForeign('trainings_group_id_foreign');
        });

        Schema::table('category_exercises', function(Blueprint $table) {
            $table->dropForeign('category_exercises_training_id_foreign');
            $table->dropForeign('category_exercises_category_id_foreign');
        });

        Schema::table('exercises', function(Blueprint $table) {
            $table->dropForeign('exercises_category_exercise_id_foreign');
        });

        Schema::table('presences', function(Blueprint $table) {
            $table->dropForeign('presences_training_id_foreign');
            $table->dropForeign('presences_swimmer_id_foreign');
        });

        Schema::table('distances', function(Blueprint $table) {
            $table->dropForeign('distances_stroke_id_foreign');
        });

        Schema::table('stopwatches', function(Blueprint $table) {
            $table->dropForeign('stopwatches_distance_id_foreign');
            $table->dropForeign('stopwatches_swimmer_id_foreign');
            //            $table->dropForeign('user_id')->references('id')->on('users')
            //                ->onDelete('cascade')
            //                ->onUpdate('cascade');
        });

        Schema::table('stopwatch_times', function(Blueprint $table) {
            $table->dropForeign('stopwatch_times_stopwatch_id_foreign');
        });

        Schema::table('gyms', function(Blueprint $table) {
            $table->dropForeign('gyms_group_id_foreign');
        });

        Schema::table('gym_exercises', function(Blueprint $table) {
            $table->dropForeign('gym_exercises_gym_id_foreign');
            $table->dropForeign('gym_exercises_g_exercise_id_foreign');
        });

        Schema::table('gym_exercises_categories', function(Blueprint $table) {
            $table->dropForeign('gym_exercises_categories_exercise_id_foreign');
            $table->dropForeign('gym_exercises_categories_category_id_foreign');
        });

        Schema::table('heart_rates', function(Blueprint $table) {
            $table->dropForeign('heart_rates_swimmer_id_foreign');
        });

        Schema::table('weights', function(Blueprint $table) {
            $table->dropForeign('weights_swimmer_id_foreign');
        });
        // Schema::table('tables', function(Blueprint $table) {
        // 	$table->dropForeign('tables_FK_area_id_foreign');
        // });
        // Schema::table('clients', function(Blueprint $table) {
        // 	$table->dropForeign('clients_FK_client_status_id_foreign');
        // });
        // Schema::table('clients', function(Blueprint $table) {
        // 	$table->dropForeign('clients_FK_table_id_foreign');
        // });
        // Schema::table('orders', function(Blueprint $table) {
        // 	$table->dropForeign('orders_FK_client_id_foreign');
        // });
        // Schema::table('waiter_area', function(Blueprint $table) {
        // 	$table->dropForeign('waiter_area_FK_waiter_id_foreign');
        // });
        // Schema::table('waiter_area', function(Blueprint $table) {
        // 	$table->dropForeign('waiter_area_FK_area_id_foreign');
        // });
    }
}
