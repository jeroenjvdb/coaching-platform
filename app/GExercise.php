<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GExercise extends Model
{
    protected $table = "g_exercises";

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'start',
        'end',
    ];

    public function gyms()
    {
        return $this->hasMany('App\Gym');
    }

    public function categories()
    {
        return $this->belongsToMany('App\GymCategory', 'gym_exercises_categories', 'exercise_id', 'category_id');
    }

}
