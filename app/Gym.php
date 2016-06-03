<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $table = "gyms";

    protected $fillable = [
        'start_time'
    ];

    public function exercises()
    {
        return $this->hasMany('App\GymExercise', 'gym_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
