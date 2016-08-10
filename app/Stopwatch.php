<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stopwatch extends Model
{
    protected $table = 'stopwatches';

    protected $fillable = [
        'is_running',
        'swimmer_id',
        'distance_id',

    ];

    protected $casts = [
        'is_running' => 'boolean',
    ];

    public function distance()
    {
        return $this->belongsTo('App\Distance');
    }

    public function swimmer()
    {
        return $this->belongsTo('App\Swimmer');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function times()
    {
        return $this->hasMany('App\StopwatchTime');
    }

    public function getBestTime()
    {
        $stroke = $this->distance->stroke->name;
        $distance = $this->distance->distance;

        $swimmer = $this->swimmer->first();

        $pb = $swimmer->getPersonalBest();
//        dd($pb);

        preg_match_all("/<tr.*?<\/tr>/", $pb, $pbArr);
        $times = [];

        $courses = preg_grep("/" . config('swimrankings.courses')[$stroke][$distance] . "<\/td>/", $pbArr[0]);
//        dd(config('swimrankings.courses')[$stroke][$distance]);
        foreach ($courses as $course) {
            preg_match('/<td class="course">.*?<\/td><td class="time">.*?<\/td>/', $course, $time);
//            dd($course);
            array_push($times, $time[0]);
        }

        return $times;
    }
}
