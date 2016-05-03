<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GymCategory extends Model
{
    protected $table = "gym_categories";

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function exercises()
    {
        return $this->belongsToMany('App\GExercise', 'gym_exercises_categories', 'category_id', 'exercise_id');
    }
}
