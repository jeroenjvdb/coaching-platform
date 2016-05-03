<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GymExercise extends Model
{
    //

    protected $table = "gym_exercises";

    protected $fillable = [
        'sets',
        'reps',
        'g_exercise_id',
    ];

    public $timestamps = false;

    public function exercise()
    {
        return $this->belongsTo('App\GExercise', 'g_exercise_id', 'id');
    }

    public function gym()
    {
        return $this->belongsTo('App\Gym');
    }



}
