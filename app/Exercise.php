<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    /**
     * the table associated with the model
     *
     * @var string
     */
    protected $table = 'exercises';

    /**
     * the attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'training_id',
        'sets',
        'meters',
        'description',
        'position',
    ];

//    protected $attributes = [
//        'total',
//    ];

    protected $appends = [
        'total',
    ];

    /**
     * the dates
     *
     * @var array
     */
    protected $dates = [
        //'created_at',
        //'updated_at',
        //'deleted_at',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function training()
    {
        return $this->belongsTo('App\Training');
    }

    public function scopeLastExercise($query)
    {
        return $query->orderBy('position', 'desc')->first();
    }


    public function getTotalAttribute()
    {
        return $this->sets * $this->meters;
    }
}
