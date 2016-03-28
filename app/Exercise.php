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

    public function scopePositioned($query)
    {
        return $query->orderBy('position', 'asc');
    }

    public function scopeLastExercise($query)
    {
        return $query->orderBy('position', 'desc')->first();
    }


    public function getTotalAttribute()
    {
        return $this->sets * $this->meters;
    }

    /**
     * change positions of the exercises
     *
     * @param Training $training
     * @param $newPos
     * @param $oldPos
     * @return bool
     */
    public function changePositions( Training $training, $newPos, $oldPos)
    {
        $exercise = $this;
        $lastPos = $newPos;
        $directionWhere = '<=';
        $directionOrderBy = 'asc';
        $directionPos = -1;

        if ($newPos < $oldPos) {
            $directionWhere = '>=';
            $directionOrderBy = 'desc';
            $directionPos = 1;
        }

        $allExercises = $training->exercises()
            ->where('position', $directionWhere, $newPos)
            ->whereNotIn('id', [$exercise->id])
            ->orderBy('position', $directionOrderBy)
            ->get();

        foreach ($allExercises as $allExercise) {
            $lastPos = $allExercise->position;
            $allExercise->position += $directionPos;
            $allExercise->save();
        }

        $exercise->position = $lastPos;
        if( ! $allExercises->count() ) {
            $exercise->position = 1;
        }
        $exercise->save();

        return true;
    }
}
