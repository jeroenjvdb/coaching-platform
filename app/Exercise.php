<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        'category_exercise_id',
    ];

    /**
     * the attributes that are added to the json form
     *
     * @var array
     */
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

    /**
     * get the training this belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo1
     */
    public function training()
    {
        return $this->belongsTo('App\Training');
    }

    /**
     * position the exercises
     *
     * @param $query
     * @return mixed
     */
    public function scopePositioned($query)
    {
        return $query->orderBy('position', 'asc');
    }

    /**
     * get the last exercise
     *
     * @param $query
     * @return mixed
     */
    public function scopeLastExercise($query)
    {
        return $query->orderBy('position', 'desc')->first();
    }

    /**
     * calculate the total meters of an exercise
     *
     * @return mixed
     */
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
    public function changePositions( Training $training, $newPos)
    {
        $oldPos = $this->position;
        $category_id = $this->category_exercise_id;

        $exercise = $this;
        $directionWhere = '<=';
        $otherDirection = '>';
        $directionOrderBy = 'desc';
        $directionPos = -1;

        if($newPos != $oldPos) {
            if ($newPos < $oldPos) {
                $directionWhere = '>=';
                $otherDirection = '<';
                $directionOrderBy = 'asc';
                $directionPos = 1;
            }

            $allExercises = $training->categoryExercises()->find($category_id)->exercises()
                ->where('position', $directionWhere, $newPos)
                ->where('position', $otherDirection, $oldPos)
                ->orderBy('position', $directionOrderBy)
                ->get();

            Log::info('', [$allExercises]);

            $counter = $allExercises->first()->position;
            $exercise->position = $counter;

            if (!$allExercises->count()) {
                $exercise->position = 0;
            }
            $exercise->save();

            foreach ($allExercises as $allExercise) {
                $counter += $directionPos;
                $allExercise->position = $counter;
                $allExercise->save();
            }
        }

        return true;
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'App\ExerciseCategory');
    }
}
