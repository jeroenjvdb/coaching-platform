<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Swimmer extends Model
{
    /**
     * the table associated with the model
     *
     * @var string
     */
    protected $table = 'swimmers';

    /**
     * the attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'profile_id',
    ];

    /**
     * the dates
     *
     * @var array
     */
    protected $dates = [
        'date_of_birth',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * the attributes to apend to json
     *
     * @var array
     */
    protected $appends = [
        'presence',
    ];

    /*
     * relations
     */

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function trainings()
    {
        return $this->belongsToMany('App\Training', 'presences');
    }

    public function stopwatches()
    {
        return $this->hasMany('App\Stopwatch');
    }

    /**
     * Get presences on training
     *
     * @param $query
     * @param null $training_id
     * @return mixed
     */
    public function scopePresences($query, $training_id = null)
    {
        return $query
            ->select('swimmers.*', DB::raw('( presences.training_id IS NOT NULL ) as present '))
            ->leftJoin('presences', function ($join) use ($training_id) {
                $join->on('presences.swimmer_id', '=', 'swimmers.id');
                if($training_id) {
                    $join->where('presences.training_id', '=', $training_id);
                }
            });
    }

    /**
     * get presences of swimmer
     *
     * @return bool|float
     */
    public function getPresenceAttribute()
    {
        $trainingCount = $this->group->trainings()->count();
        $trainingPresences = $this->trainings()->count();
        if( $trainingCount != 0 ) {
            $presence = $trainingPresences/$trainingCount;
            
            return round($presence, 2);
        } 

        return false;
    }
}
