<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CategoryExercise extends Model
{
    protected $table = "category_exercises";

    public $timestamps = false;

    protected $fillable = [
        'training_id',
        'category_id',
        'position',
    ];

    public function exercises()
    {
        return $this->hasMany('App\Exercise', 'category_exercise_id');
    }

    public function training()
    {
        return $this->hasOne('App\Training', 'id', 'training_id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    public function scopePositioned($query)
    {
        return $query->orderBy('position', 'asc');
    }

    public function getTotalAttribute()
    {
        return $this->exercises->sum('total');
    }

    public function changePosition($training, $newPos)
    {
        $oldPos = $this->position;
//        $category_id = $this->category_exercise_id;

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

            $allCategories = $training->categoryExercises()
                ->where('position', $directionWhere, $newPos)
                ->where('position', $otherDirection, $oldPos)
                ->orderBy('position', $directionOrderBy)
                ->get();

//            Log::info('', [$allCategories]);

            $counter = $allCategories->first()->position;
            $this->position = $counter;

            if (!$allCategories->count()) {
                $this->position = 0;
            }
            $this->save();

            foreach ($allCategories as $allExercise) {
                $counter += $directionPos;
                $allExercise->position = $counter;
                $allExercise->save();
            }
        }

        return true;
    }
}
