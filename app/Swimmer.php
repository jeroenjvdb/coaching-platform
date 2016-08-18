<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Phoenix\EloquentMeta\MetaTrait;
use App\Traits\SwimmerProfile;

class Swimmer extends Model
{
    use MetaTrait;
    use SwimmerProfile;
    use SoftDeletes;

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
        'swimrankings_id',
        'email',
        'birthday',
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function trainings()
    {
        return $this->belongsToMany('App\Training', 'presences')->withPivot('is_present');
    }

    public function data()
    {
        return $this->hasMany('App\Data');
    }

    public function stopwatches()
    {
        return $this->hasMany('App\Stopwatch');
    }

    public function heartRates()
    {
        return $this->hasMany('App\HeartRate');
    }

    public function weights()
    {
        return $this->hasMany('App\Weight');
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('last_name', 'asc');
    }

    /**
     * get presences of swimmer
     *
     * @return bool|float
     */
    public function getPresenceAttribute()
    {
        $trainingCount = $this->trainings()->count();
        $trainings = $this->trainings;
        $count = 0;
        foreach($trainings as $training) {
            if($training->pivot->is_present) {
                $count++;
            }
        }
        if( $count != 0 ) {
            $presence = $count/$trainingCount;

            return round($presence, 2);
        }

        return false;
    }

    public function presences($start, $end)
    {
        $trainings = $this
            ->trainings()
            ->where('starttime', '>', $start)
            ->where('starttime', '<', $end)
            ->get();
        $trainingCount = $trainings->count();
        $count = 0;
        foreach($trainings as $training) {
            if($training->pivot->is_present) {
                $count++;
            }
        }
        if( $count != 0 ) {
            $presence = $count/$trainingCount;

            return round($presence, 2);
        }

        return false;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

}
